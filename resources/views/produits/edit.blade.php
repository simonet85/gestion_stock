@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Modifier le Produit</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produits.update', $produit->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nom" class="block text-gray-700 font-medium mb-2">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $produit->nom) }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" id="description" class="w-full px-4 py-2 border rounded-lg">{{ old('description', $produit->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="quantite_stock" class="block text-gray-700 font-medium mb-2">Quantité en Stock</label>
            <input type="number" name="quantite_stock" id="quantite_stock" value="{{ old('quantite_stock', $produit->quantite_stock) }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="seuil_reapprovisionnement" class="block text-gray-700 font-medium mb-2">Seuil de Réapprovisionnement</label>
            <input type="number" name="seuil_reapprovisionnement" id="seuil_reapprovisionnement" value="{{ old('seuil_reapprovisionnement', $produit->seuil_reapprovisionnement) }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="fournisseur_id" class="block text-gray-700 font-medium mb-2">Fournisseur</label>
            <select name="fournisseur_id" id="fournisseur_id" class="w-full px-4 py-2 border rounded-lg" required>
                @foreach ($fournisseurs as $fournisseur)
                    <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id', $produit->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>
                        {{ $fournisseur->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Enregistrer les Modifications
        </button>
    </form>
</div>
@endsection
