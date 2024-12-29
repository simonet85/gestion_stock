@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Ajouter un Produit</h1>
        <a href="{{ route('produits.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold">Erreurs de validation</span>
            </div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg max-w-3xl mx-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <h2 class="text-lg font-medium text-gray-800">Informations du Produit</h2>
            </div>
        </div>

        <form action="{{ route('produits.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nom" 
                           id="nom" 
                           value="{{ old('nom') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                           required>
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" 
                            id="category_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ old('category_id') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom_catégorie }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="3" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="quantite_stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Quantité en Stock <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="quantite_stock" 
                           id="quantite_stock" 
                           value="{{ old('quantite_stock') }}"
                           min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                           required>
                </div>

                <div>
                    <label for="seuil_reapprovisionnement" class="block text-sm font-medium text-gray-700 mb-2">
                        Seuil de Réapprovisionnement <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="seuil_reapprovisionnement" 
                           id="seuil_reapprovisionnement" 
                           value="{{ old('seuil_reapprovisionnement') }}"
                           min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                           required>
                </div>

                <div class="md:col-span-2">
                    <label for="fournisseur_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Fournisseur <span class="text-red-500">*</span>
                    </label>
                    <select name="fournisseur_id" 
                            id="fournisseur_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            required>
                        <option value="">Sélectionnez un fournisseur</option>
                        @foreach ($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                                {{ $fournisseur->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <button type="reset" 
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 transition duration-200">
                    Réinitialiser
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 transition duration-200">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
