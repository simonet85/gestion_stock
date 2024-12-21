@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Ajouter un Produit</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produits.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label for="nom" class="block text-gray-700 font-medium mb-2">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" id="description" class="w-full px-4 py-2 border rounded-lg">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="quantite_stock" class="block text-gray-700 font-medium mb-2">Quantité en Stock</label>
            <input type="number" name="quantite_stock" id="quantite_stock" value="{{ old('quantite_stock') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <!-- Dropdown for Categories -->
            <label for="category_id" class="block text-gray-700 font-medium mb-2">Catégorie</label>
            <select name="category_id" id="category_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Sélectionnez une catégorie</option>
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('category_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom_catégorie }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="seuil_reapprovisionnement" class="block text-gray-700 font-medium mb-2">Seuil de Réapprovisionnement</label>
            <input type="number" name="seuil_reapprovisionnement" id="seuil_reapprovisionnement" value="{{ old('seuil_reapprovisionnement') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <!-- Dropdown for Fournisseurs -->
            <label for="fournisseur_id" class="block text-gray-700 font-medium mb-2">Fournisseur</label>
            <select name="fournisseur_id" id="fournisseur_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Sélectionnez un fournisseur</option>
                @foreach ($fournisseurs as $fournisseur)
                    <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                        {{ $fournisseur->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Enregistrer
        </button>
    </form>
</div>
@endsection
