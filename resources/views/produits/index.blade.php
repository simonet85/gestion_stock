@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Liste des Produits</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('produits.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
        Ajouter un Produit
    </a>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Nom</th>
                <th class="border border-gray-300 px-4 py-2">Description</th>
                <th class="border border-gray-300 px-4 py-2">Quantité</th>
                <th class="border border-gray-300 px-4 py-2">Seuil</th>
                <th class="border border-gray-300 px-4 py-2">Fournisseur</th>
                <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produits as $produit)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $produit->nom }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $produit->description }}</td>
                    @if ($produit->quantite_stock < $produit->seuil_reapprovisionnement)
                        <td class="border border-gray-300 px-4 py-2">
                            <span class="text-red-500">{{ $produit->quantite_stock }} (Stock Faible)</span>
                        </td>
                    @else
                        <td class="border border-gray-300 px-4 py-2">
                           <span class="text-green-500"> {{ $produit->quantite_stock }} (Stock Normal)</span>
                        </td>
                    @endif
                    <td class="border border-gray-300 px-4 py-2">{{ $produit->seuil_reapprovisionnement }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $produit->fournisseur->nom }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('produits.edit', $produit->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">
                            Modifier
                        </a>
                        <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
