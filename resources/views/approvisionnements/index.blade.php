<!-- resources/views/approvisionnements/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Liste des Approvisionnements</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('approvisionnements.create') }}" 
       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow mb-4 inline-block">
        Ajouter un Approvisionnement
    </a>

    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Produit</th>
                <th class="border border-gray-300 px-4 py-2">Quantité</th>
                <th class="border border-gray-300 px-4 py-2">Prix Unitaire</th>
                <th class="border border-gray-300 px-4 py-2">Fournisseur</th>
                <th class="border border-gray-300 px-4 py-2">Date</th>
                <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($approvisionnements as $approvisionnement)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $approvisionnement->produit->nom }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $approvisionnement->quantité_fournie }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($approvisionnement->prix_unitaire, 2) }} CFA</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $approvisionnement->fournisseur->nom }}</td>
                    <!--format the date in the following way: dd/mm/yyyy-->
                    <td class="border border-gray-300 px-4 py-2">{{ date('d/m/Y', strtotime($approvisionnement->date_livraison)) }}</td>
                    <td class="border border-gray-300 px-4 py-2 flex justify-center space-x-2">
                        <a href="{{ route('approvisionnements.edit', $approvisionnement->id) }}" 
                           class="text-blue-500 hover:text-blue-600">Modifier</a>
                        <form action="{{ route('approvisionnements.destroy', $approvisionnement->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-500 hover:text-red-600"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet approvisionnement ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-6">Aucun approvisionnement trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $approvisionnements->links() }}
    </div>
</div>
@endsection
