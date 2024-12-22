<!-- resources/views/approvisionnements/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Ajouter un Approvisionnement</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 border border-red-400 rounded p-4 mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('approvisionnements.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="produit_id" class="block text-gray-700 font-medium mb-2">Produit</label>
            <select name="produit_id" id="produit_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Sélectionnez un produit</option>
                @foreach ($produits as $produit)
                    <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="quantité_fournie" class="block text-gray-700 font-medium mb-2">Quantité</label>
            <input type="number" name="quantité_fournie" id="quantité_fournie" 
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="prix_unitaire" class="block text-gray-700 font-medium mb-2">Prix Unitaire (CFA)</label>
            <input type="number" step="0.01" name="prix_unitaire" id="prix_unitaire" 
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="date_livraison" class="block text-gray-700 font-medium mb-2">Date d'Approvisionnement</label>
            <input type="date" name="date_livraison" id="date_livraison" 
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="fournisseur_id" class="block text-gray-700 font-medium mb-2">Fournisseur</label>
            <select name="fournisseur_id" id="fournisseur_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Sélectionnez un fournisseur</option>
                @foreach ($fournisseurs as $fournisseur)
                    <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" 
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
            Enregistrer
        </button>
    </form>
</div>
@endsection
