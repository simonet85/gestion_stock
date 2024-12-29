@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Modifier la Commande #{{ $commande->id }}</h1>
        <a href="{{ route('commandes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Retour
        </a>
    </div>

    <form action="{{ route('commandes.update', $commande->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="date_commande">
                Date de Commande
            </label>
            <input type="date" 
                   name="date_commande" 
                   id="date_commande"
                   value="{{ $commande->date_commande }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="statut">
                Statut
            </label>
            <select name="statut" 
                    id="statut"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="En cours" {{ $commande->statut === 'En cours' ? 'selected' : '' }}>En cours</option>
                <option value="Validé" {{ $commande->statut === 'Validé' ? 'selected' : '' }}>Validé</option>
                <option value="Annulé" {{ $commande->statut === 'Annulé' ? 'selected' : '' }}>Annulé</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="user_id">
                Utilisateur
            </label>
            <select name="user_id" 
                    id="user_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $commande->user_id === $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Produits
            </label>
            <div id="produits-container">
                @foreach($commande->produits as $commandeProduit)
                    <div class="flex gap-4 mb-2 produit-row">
                        <select name="produits[][id]" class="produit-select w-1/2">
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id }}" 
                                        data-prix="{{ $produit->prix_unitaire }}"
                                        {{ $commandeProduit->id === $produit->id ? 'selected' : '' }}>
                                    {{ $produit->nom }} (Prix: {{ number_format($produit->prix_unitaire, 2) }} CFA)
                                </option>
                            @endforeach
                        </select>
                        <input type="number" 
                               name="produits[][quantite]"
                               value="{{ $commandeProduit->pivot->quantite }}"
                               min="1"
                               class="quantite-input w-1/4"
                               placeholder="Quantité">
                        <button type="button" 
                                class="remove-produit bg-red-500 text-white px-2 py-1 rounded">
                            Supprimer
                        </button>
                    </div>
                @endforeach
            </div>
            <button type="button" 
                    id="add-produit"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2">
                Ajouter un produit
            </button>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Mettre à jour
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('produits-container');
    const addButton = document.getElementById('add-produit');

    addButton.addEventListener('click', function() {
        const produitRow = document.createElement('div');
        produitRow.className = 'flex gap-4 mb-2 produit-row';
        
        const select = document.querySelector('.produit-select').cloneNode(true);
        select.value = '';
        
        const quantiteInput = document.createElement('input');
        quantiteInput.type = 'number';
        quantiteInput.name = 'produits[][quantite]';
        quantiteInput.min = '1';
        quantiteInput.className = 'quantite-input w-1/4';
        quantiteInput.placeholder = 'Quantité';

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'remove-produit bg-red-500 text-white px-2 py-1 rounded';
        removeButton.textContent = 'Supprimer';
        
        removeButton.addEventListener('click', function() {
            produitRow.remove();
        });

        produitRow.appendChild(select);
        produitRow.appendChild(quantiteInput);
        produitRow.appendChild(removeButton);
        container.appendChild(produitRow);
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-produit')) {
            e.target.closest('.produit-row').remove();
        }
    });
});
</script>
@endsection
