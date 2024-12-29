@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Modifier l'Approvisionnement</h1>
        <a href="{{ route('approvisionnements.index') }}" 
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
                <h2 class="text-lg font-medium text-gray-800">Informations d'Approvisionnement</h2>
            </div>
        </div>

        <form action="{{ route('approvisionnements.update', $approvisionnement->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="produit_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Produit <span class="text-red-500">*</span>
                    </label>
                    <select name="produit_id" 
                            id="produit_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            required>
                        @foreach ($produits as $produit)
                            <option value="{{ $produit->id }}" {{ $approvisionnement->produit_id == $produit->id ? 'selected' : '' }}>
                                {{ $produit->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="fournisseur_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Fournisseur <span class="text-red-500">*</span>
                    </label>
                    <select name="fournisseur_id" 
                            id="fournisseur_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            required>
                        @foreach ($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id }}" {{ $approvisionnement->fournisseur_id == $fournisseur->id ? 'selected' : '' }}>
                                {{ $fournisseur->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="quantité_fournie" class="block text-sm font-medium text-gray-700 mb-2">
                        Quantité <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="quantité_fournie" 
                           id="quantité_fournie" 
                           value="{{ $approvisionnement->quantité_fournie }}"
                           min="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                           required>
                </div>

                <div>
                    <label for="prix_unitaire" class="block text-sm font-medium text-gray-700 mb-2">
                        Prix Unitaire (CFA) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           step="0.01" 
                           name="prix_unitaire" 
                           id="prix_unitaire" 
                           value="{{ $approvisionnement->prix_unitaire }}"
                           min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                           required>
                </div>

                <div class="md:col-span-2">
                    <label for="date_livraison" class="block text-sm font-medium text-gray-700 mb-2">
                        Date d'Approvisionnement <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="date_livraison" 
                           id="date_livraison" 
                           value="{{ $approvisionnement->date_livraison }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                           required>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <button type="reset" 
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 transition duration-200">
                    Réinitialiser
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 transition duration-200">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
