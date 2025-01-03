<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Facture;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\ProduitAlerte;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['user', 'produits' => function ($query) {
            $query->select('produits.*')
                ->withPivot('quantite', 'prix_unitaire');
        }])
        ->orderBy('date_commande', 'desc')
        ->paginate(10);
    
        return view('commandes.index', compact('commandes'));
    }

    public function create()
    {
        $produits = Produit::with(['approvisionnements' => function ($query) {
            $query->orderBy('date_livraison', 'desc')->limit(1);
        }])->get()->map(function ($produit) {
            $produit->latest_prix_unitaire = $produit->approvisionnements()->orderBy('date_livraison', 'desc')->value('prix_unitaire');
            return $produit;
        });
        
        $users = User::all();
        return view('commandes.create', compact('produits', 'users'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_commande' => 'required|date',
            'statut' => 'required|in:En cours,Validé,Annulé',
            'produits' => 'required|array',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
        ]);
    
        try {
            return DB::transaction(function () use ($validated) {
                $totalQuantite = 0;
                $totalMontant = 0;
                $produitsData = [];
    
                // Validate stock availability first
                foreach ($validated['produits'] as $produitData) {
                    $produit = Produit::findOrFail($produitData['id']);
                    if ($produit->quantite_stock < $produitData['quantite']) {
                        throw new \Exception("Stock insuffisant pour {$produit->nom}");
                    }
                    $prixUnitaire = $produit->getLatestPrice();
                    $produitsData[] = [
                        'produit' => $produit,
                        'quantite' => $produitData['quantite'],
                        'prix_unitaire' => $prixUnitaire
                    ];
                    
                    $totalQuantite += $produitData['quantite'];
                    $totalMontant += ($prixUnitaire * $produitData['quantite']);
                }
    
                $commande = Commande::create([
                    'date_commande' => $validated['date_commande'],
                    'statut' => $validated['statut'],
                    'quantité_totale' => $totalQuantite,
                    'montant_total' => $totalMontant,
                    'user_id' => $validated['user_id'],
                ]);
    
                foreach ($produitsData as $data) {
                    $commande->produits()->attach($data['produit']->id, [
                        'quantite' => $data['quantite'],
                        'prix_unitaire' => $data['prix_unitaire']
                    ]);
    
                    $data['produit']->updateStock($data['quantite'], 'decrement');
                }

                // Create invoice with correct status
                if ($validated['statut'] === 'Validé') {
                    Facture::create([
                        'commande_id' => $commande->id,
                        'user_id' => $validated['user_id'],
                        'montant' => $totalMontant,
                        'statut_paiement' => 'payé'
                    ]);

                    // Record transaction for validated orders
                    foreach ($produitsData as $data) {
                        Transaction::create([
                            'type' => 'vente',
                            'quantité' => $data['quantite'],
                            'date_transaction' => now(),
                            'user_id' => $validated['user_id'],
                            'produit_id' => $data['produit']->id
                        ]);
                    }
                }elseif ($validated['statut'] === 'Annulé') {
                    // Record transaction for validated orders
                    foreach ($produitsData as $data) {
                        Transaction::create([
                            'type' => 'annulé',
                            'quantité' => $data['quantite'],
                            'date_transaction' => now(),
                            'user_id' => $validated['user_id'],
                            'produit_id' => $data['produit']->id
                        ]);
                    }
                }else {
                    Facture::create([
                        'commande_id' => $commande->id,
                        'user_id' => $validated['user_id'],
                        'montant' => $totalMontant,
                        'statut_paiement' => 'en_attente'
                    ]);
                }

                //Record transaction
                Transaction::recordSale($commande);

                //Generate invoice 
                Facture::generateFromOrder($commande);
    
                return redirect()->route('commandes.index')
                    ->with('success', 'Commande créée avec succès.');

            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
    

    public function edit(string $id)
    {
        $commande = Commande::with(['produits' => function ($query) {
            $query->select('produits.*')
            ->withPivot('quantite', 'prix_unitaire');
        }])->findOrFail($id);
    
        $produits = Produit::with(['approvisionnements' => function ($query) {
            $query->orderBy('date_livraison', 'desc')->limit(1);
        }])->get()->map(function ($produit) {
            $produit->latest_prix_unitaire = $produit->approvisionnements()->orderBy('date_livraison', 'desc')->value('prix_unitaire');
            return $produit;
        });
    
        $users = User::all();
    
        return view('commandes.edit', compact('commande', 'produits', 'users'));
    }
    

    public function update(Request $request, $id = null)
    {
        $validated = $request->validate([
            'date_commande' => 'required|date',
            'statut' => 'required|in:En cours,Validé,Annulé',
            'produits' => 'required|array',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
        ]);
    
        try {
            return DB::transaction(function () use ($validated, $id) {
                $commande = $id ? Commande::findOrFail($id) : new Commande();
                $isUpdate = $commande->exists;
    
                $totalQuantite = 0;
                $totalMontant = 0;
                $produitsData = [];
    
                // Validate stock availability and calculate totals
                foreach ($validated['produits'] as $produitData) {
                    $produit = Produit::findOrFail($produitData['id']);
                    if (!$isUpdate && $produit->quantite_stock < $produitData['quantite']) {
                        throw new \Exception("Stock insuffisant pour {$produit->nom}");
                    }
    
                    $prixUnitaire = $produit->getLatestPrice();
                    $produitsData[] = [
                        'produit' => $produit,
                        'quantite' => $produitData['quantite'],
                        'prix_unitaire' => $prixUnitaire
                    ];
    
                    $totalQuantite += $produitData['quantite'];
                    $totalMontant += ($prixUnitaire * $produitData['quantite']);
                }
    
                // Update or create the commande
                $commande->fill([
                    'date_commande' => $validated['date_commande'],
                    'statut' => $validated['statut'],
                    'quantité_totale' => $totalQuantite,
                    'montant_total' => $totalMontant,
                    'user_id' => $validated['user_id'],
                ]);
                $commande->save();
    
                // Synchronize products for updates
                $commande->produits()->sync([]);
                foreach ($produitsData as $data) {
                    $commande->produits()->attach($data['produit']->id, [
                        'quantite' => $data['quantite'],
                        'prix_unitaire' => $data['prix_unitaire']
                    ]);
    
                    if (!$isUpdate) {
                        $data['produit']->updateStock($data['quantite'], 'decrement');
                    }
                }
    
                // Handle status-specific actions
                if ($validated['statut'] === 'Validé') {
                    Facture::updateOrCreate(
                        ['commande_id' => $commande->id],
                        [
                            'user_id' => $validated['user_id'],
                            'montant' => $totalMontant,
                            'statut_paiement' => 'payé'
                        ]
                    );
                } elseif ($validated['statut'] === 'Annulé') {
                    foreach ($produitsData as $data) {
                        Transaction::create([
                            'type' => 'annulé',
                            'quantité' => $data['quantite'],
                            'date_transaction' => now(),
                            'user_id' => $validated['user_id'],
                            'produit_id' => $data['produit']->id
                        ]);
                    }
                } else {
                    Facture::updateOrCreate(
                        ['commande_id' => $commande->id],
                        [
                            'user_id' => $validated['user_id'],
                            'montant' => $totalMontant,
                            'statut_paiement' => 'en_attente'
                        ]
                    );
                }
    
                return redirect()->route('commandes.index')
                    ->with('success', $isUpdate ? 'Commande mise à jour avec succès.' : 'Commande créée avec succès.');
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    
    
    
    
    

    public function destroy(Commande $commande)
    {
        DB::transaction(function () use ($commande) {
            foreach ($commande->produits as $produit) {
                $produit->increment('quantite_stock', $produit->pivot->quantite);
            }
            $commande->delete();
        });

        return redirect()->route('commandes.index')->with('success', 'Commande supprimée avec succès.');
    }

    private function triggerLowStockAlert($produit)
    {
        $alerte = [
            'produit_id' => $produit->id,
            'quantite_stock' => $produit->quantite_stock,
            'seuil_reapprovisionnement' => $produit->seuil_reapprovisionnement,
        ];

        if ($produit->fournisseur) {
            $produit->fournisseur->notify(new App\Notifications\ProduitAlerte($alerte));
        }

        User::role('Administrateur')->each(function ($admin) use ($alerte) {
            $admin->notify(new ProduitAlerte($alerte));
        });
    }
}
