@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="bg-white rounded-xl shadow-lg max-w-4xl mx-auto">
        <div class="p-8">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Facture #{{ $facture->id }}</h1>
                    <p class="text-gray-600">Date: {{ $facture->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('factures.pdf', $facture->id) }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Télécharger PDF
                    </a>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-8">
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Client</h3>
                        <p>{{ $facture->user->name }}</p>
                        <p>{{ $facture->user->email }}</p>
                    </div>
                    <div class="text-right">
                        <h3 class="text-lg font-semibold mb-4">Statut</h3>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            {{ $facture->statut_paiement === 'payé' ? 'bg-green-100 text-green-800' : 
                              ($facture->statut_paiement === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($facture->statut_paiement) }}
                        </span>
                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200 mb-8">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix Unitaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($facture->commande->produits as $produit)
                        <tr>
                            <td class="px-6 py-4">{{ $produit->nom }}</td>
                            <td class="px-6 py-4">{{ $produit->pivot->quantite }}</td>
                            <td class="px-6 py-4">{{ number_format($produit->pivot->prix_unitaire, 2) }} CFA</td>
                            <td class="px-6 py-4">{{ number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 2) }} CFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold">Total</span>
                            <span>{{ number_format($facture->montant, 2) }} CFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
