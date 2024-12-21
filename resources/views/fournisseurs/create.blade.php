@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Ajouter un Fournisseur</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('fournisseurs.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label for="nom" class="block text-gray-700 font-medium mb-2">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 font-medium mb-2">Adresse</label>
            <input type="text" name="address" id="address" value="{{ old('address') }}" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label for="telephone" class="block text-gray-700 font-medium mb-2">Téléphone</label>
            <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Enregistrer
        </button>
    </form>
</div>
@endsection
