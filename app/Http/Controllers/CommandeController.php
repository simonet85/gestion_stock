<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
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
    
        $produits = Produit::select('produits.*')
            ->addSelect([
                'prix_unitaire' => \DB::table('approvisionnements')
                    ->select('prix_unitaire')
                    ->whereColumn('approvisionnements.produit_id', 'produits.id')
                    ->orderBy('date_livraison', 'desc')
                    ->limit(1)
            ])
            ->get();
    
        $users = User::all();
    
        return view('commandes.edit', compact('commande', 'produits', 'users'));
    }
    

    public function update(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'date_commande' => 'required|date',
            'statut' => 'required|in:En cours,Validé,Annulé',
            'produits' => 'required|array',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
        ]);

        DB::transaction(function () use ($validated, $commande) {
            $commande->update([
                'date_commande' => $validated['date_commande'],
                'statut' => $validated['statut'],
                'user_id' => $validated['user_id'],
            ]);

            $totalQuantite = 0;
            $totalMontant = 0;

            $commande->produits()->detach();

            foreach ($validated['produits'] as $produitData) {
                $produit = Produit::findOrFail($produitData['id']);
                $quantite = $produitData['quantite'];
                $prixUnitaire = $produit->approvisionnements()->latest('date_livraison')->value('prix_unitaire') ?? 0;

                $commande->produits()->attach($produit->id, [
                    'quantite' => $quantite,
                    'prix_unitaire' => $prixUnitaire,
                ]);

                $totalQuantite += $quantite;
                $totalMontant += $prixUnitaire * $quantite;

                $produit->increment('quantite_stock', $quantite);
                $produit->decrement('quantite_stock', $quantite);

                if ($produit->quantite_stock < $produit->seuil_reapprovisionnement) {
                    $this->triggerLowStockAlert($produit);
                }
            }

            $commande->update([
                'quantité_totale' => $totalQuantite,
                'montant_total' => $totalMontant,
            ]);
        });

        return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès.');
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
