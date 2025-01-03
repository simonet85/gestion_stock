<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Facture;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Approvisionnement;
use Illuminate\Support\Facades\DB;
use App\Notifications\ProduitAlerte;


class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produit::with('fournisseur')->get();
        //fetch all produits with their fournisseur and pass it to the view in descending order and paginate it
        $produits = Produit::with('fournisseur')->orderBy('created_at', 'desc')->paginate(10);

        //Si quantite_stock < seuil_reapprovisionnement, déclencher une alerte.
        foreach ($produits as $produit) {
            if ($produit->quantite_stock < $produit->seuil_reapprovisionnement) {
                // Check if a notification for this product already exists
                $existingNotification = auth()->user()->notifications()
                    ->where('type', \App\Notifications\ProduitAlerte::class)
                    ->whereJsonContains('data->alerte->produit_id', $produit->id)
                    ->whereNull('read_at')
                    ->first();
        
                if (!$existingNotification) {
                    // Generate alert data
                    $alerte = [
                        'produit_id' => $produit->id,
                        'produit_nom' => $produit->nom,
                        'quantite_stock' => $produit->quantite_stock,
                        'seuil_reapprovisionnement' => $produit->seuil_reapprovisionnement,
                    ];
        
                    // Notify the supplier
                    $fournisseur = $produit->fournisseur;
                    $fournisseur->notify(new \App\Notifications\ProduitAlerte($alerte));
        
                    // Notify the admin
                    $admin = User::whereHas('roles', function ($query) {
                        $query->where('name', 'Administrateur');
                    })->first();
        
                    if ($admin) {
                        $admin->notify(new \App\Notifications\ProduitAlerte($alerte));
                    }
                }
            }
        }
        

        return view('produits.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fournisseurs = Fournisseur::all();
        $categories = Categorie::all();
        return view('produits.create',compact('fournisseurs', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantite_stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'seuil_reapprovisionnement' => 'required|integer|min:1',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
        ]);

    try {
         DB::transaction(function () use ($validated) {
            // Create the product
            $produit = Produit::create($validated);

            // Record initial stock transaction
            Transaction::create([
                'type' => 'achat',
                'quantité' => $validated['quantite_stock'],
                'date_transaction' => now(),
                'user_id' => auth()->id(),
                'produit_id' => $produit->id
            ]);
        });
        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()
        ->withInput()
        ->withErrors(['error' => $e->getMessage()]);
    }
      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fournisseurs = Fournisseur::all();
        $produit = Produit::findOrFail($id);
        $categories = Categorie::all();
        return view('produits.edit', compact('produit', 'fournisseurs', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantite_stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'seuil_reapprovisionnement' => 'required|integer|min:1',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
        ]);

        $produit = Produit::findOrFail($id);
        $produit->update($request->all());
        return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec sucees.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }
}
