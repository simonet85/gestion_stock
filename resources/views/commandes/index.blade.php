@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Liste des Commandes</h1>
        <a href="{{ route('commandes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nouvelle Commande
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Produits Commandés</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Montant Total</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($commandes as $commande)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{ $commande->date_commande->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $commande->statut === 'En cours' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($commande->statut === 'Validé' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ $commande->statut }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{ $commande->user->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <ul class="list-disc list-inside">
                                @foreach ($commande->produits as $produit)
                                    <li>
                                        {{ $produit->nom }} 
                                        (Prix: {{ number_format($produit->pivot->prix_unitaire, 2, ',', ' ') }} CFA, 
                                        Quantité: {{ $produit->pivot->quantite }})
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <!-- <td class="border border-gray-300 px-4 py-2">
                            {{ number_format($commande->montant_total, 2, ',', ' ') }} CFA
                        </td> -->

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300">{{ number_format($commande->montant_total, 2) }} CFA</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 text-sm leading-5 font-medium">
                            <a href="{{ route('commandes.edit', $commande->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Modifier</a>
                            <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 border-b border-gray-300 text-center">Aucune commande trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $commandes->links() }}
    </div>
</div>
@endsection
