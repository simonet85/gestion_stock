@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Créer une Commande</h1>
        <a href="{{ route('commandes.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            Retour
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
            <div class="font-bold">Erreurs de validation:</div>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('commandes.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Date et Statut -->
            <div>
                <label for="date_commande" class="block text-sm font-medium text-gray-700 mb-2">
                    Date de la Commande
                </label>
                <input type="date" 
                       name="date_commande" 
                       id="date_commande" 
                       value="{{ old('date_commande', date('Y-m-d')) }}" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                       required>
            </div>

            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                    Statut
                </label>
                <select name="statut" 
                        id="statut" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                        required>
                    <option value="En cours">En cours</option>
                    <option value="Validé">Validé</option>
                    <option value="Annulé">Annulé</option>
                </select>
            </div>
        </div>

        <!-- Utilisateur -->
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                Utilisateur
            </label>
            <select name="user_id" 
                    id="user_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                    required>
                <option value="">Sélectionnez un utilisateur</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Produits -->
        <div class="bg-gray-50 p-4 rounded-lg">
    <h2 class="text-lg font-medium text-gray-700 mb-4">Sélection des Produits</h2>
    <div class="space-y-3">
                @foreach ($produits as $index => $produit)
                    <div class="flex items-center space-x-4 p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center space-x-3 flex-1">
                            <input type="checkbox" 
                                id="produit-{{ $produit->id }}" 
                                name="produits[{{ $index }}][id]" 
                                value="{{ $produit->id }}" 
                                class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                                onchange="toggleQuantite({{ $produit->id }})">
                            <div class="flex-1">
                                <label for="produit-{{ $produit->id }}" class="font-medium text-gray-700">
                                    {{ $produit->nom }}
                                </label>
                                <p class="text-sm text-gray-500">
                                    Prix: {{ number_format($produit->latest_prix_unitaire, 2) }} CFA
                                </p>

                            </div>
                        </div>
                        <div class="w-32">
                            <input type="number" 
                                name="produits[{{ $index }}][quantite]" 
                                id="quantite-{{ $produit->id }}" 
                                min="1"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                placeholder="Quantité"
                                disabled>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="flex justify-end space-x-4 mt-6">
            <button type="reset" 
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 transition duration-200">
                Réinitialiser
            </button>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 transition duration-200">
                Créer la Commande
            </button>
        </div>
    </form>
</div>

<script>
function toggleQuantite(produitId) {
    const quantiteInput = document.getElementById(`quantite-${produitId}`);
    const checkbox = document.getElementById(`produit-${produitId}`);
    
    quantiteInput.disabled = !checkbox.checked;
    if (!checkbox.checked) {
        quantiteInput.value = '';
    } else {
        quantiteInput.value = '1';
        quantiteInput.focus();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const checkedProducts = document.querySelectorAll('input[type="checkbox"]:checked');
        if (checkedProducts.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un produit.');
        }
    });
});
</script>
@endsection
