<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Fournisseur;
use App\Models\User;
use App\Notifications\ProduitAlerte;
use App\Models\Categorie;


class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = Produit::with('fournisseur')->get();

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
        // dd($request->all());
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantite_stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'seuil_reapprovisionnement' => 'required|integer|min:1',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
        ]);


        Produit::create($request->all());
        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès.');
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
