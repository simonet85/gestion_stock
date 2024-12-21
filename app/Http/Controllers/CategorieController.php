<?php

namespace App\Http\Controllers;
use App\Models\Categorie;

use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Fetch all categories and pass it to the view
        $categories = Categorie::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Create a new category
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Store a new category
        $request->validate([
            'nom_catégorie' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Categorie::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Categorie ajouté avec sucees.');
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
        //Edit a category
        $categorie = Categorie::findOrFail($id);
        return view('categories.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Update a category
        $request->validate([
            'nom_catégorie' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $categorie = Categorie::findOrFail($id);
        $categorie->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Categorie mis à jour avec sucees.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Delete a category
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();
        return redirect()->route('categories.index')->with('success', 'Categorie supprimé avec sucees.');
    }
}
