<?php

namespace App\Http\Controllers;

use App\Models\Approvisionnement;
use App\Models\Produit;
use App\Models\Fournisseur;

use Illuminate\Http\Request;

class ApprovisionnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $approvisionnements = Approvisionnement::with(['produit', 'fournisseur'])->paginate(10);
        return view('approvisionnements.index', compact('approvisionnements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = Produit::all();
        $fournisseurs = Fournisseur::all();
        return view('approvisionnements.create', compact('produits', 'fournisseurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantité_fournie' => 'required|integer',
            'prix_unitaire' => 'required|numeric',
            'date_livraison' => 'required|date',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
        ]);

        Approvisionnement::create($validated);

        // Update stock for the product
        $produit = Produit::find($validated['produit_id']);
        $produit->increment('quantite_stock', $validated['quantité_fournie']);

        return redirect()->route('approvisionnements.index')->with('success', 'Approvisionnement ajouté avec succès.');
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
        $produits = Produit::all();
        $fournisseurs = Fournisseur::all();
        $approvisionnement = Approvisionnement::findOrFail($id);
        return view('approvisionnements.edit', compact('approvisionnement', 'produits', 'fournisseurs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  string $id)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantité_fournie' => 'required|integer',
            'prix_unitaire' => 'required|numeric',
            'date_livraison' => 'required|date',
            'fournisseur_id' => 'required|exists:fournisseurs,id',

            // "produit_id" => "1"
            // "quantité_fournie" => "49"
            // "prix_unitaire" => "499.99"
            // "date_livraison" => "2024-11-01"
            // "fournisseur_id" => "1"
        ]);

        $approvisionnement = Approvisionnement::findOrFail($id);
        $approvisionnement->update($validated);

        return redirect()->route('approvisionnements.index')->with('success', 'Approvisionnement mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */    
    public function destroy(string $id)
    {
        $approvisionnement = Approvisionnement::findOrFail($id);
        $approvisionnement->delete();
        return redirect()->route('approvisionnements.index')->with('success', 'Approvisionnement supprimé.');
    }
}
