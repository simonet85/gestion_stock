@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Liste des Fournisseurs</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('fournisseurs.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
        Ajouter un Fournisseur
    </a>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Nom</th>
                <th class="border border-gray-300 px-4 py-2">Adresse</th>
                <th class="border border-gray-300 px-4 py-2">Téléphone</th>
                <th class="border border-gray-300 px-4 py-2">Email</th>
                <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fournisseurs as $fournisseur)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $fournisseur->nom }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $fournisseur->adresse }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $fournisseur->téléphone }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $fournisseur->email }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('fournisseurs.edit', $fournisseur->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">
                            Modifier
                        </a>
                        <form action="{{ route('fournisseurs.destroy', $fournisseur->id) }}" method="POST" style="display:inline;">
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
