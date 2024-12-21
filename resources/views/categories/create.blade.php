@extends('layouts.app')

@section('content')
<!-- tailwindcss -->
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Ajouter une Categorie</h1>  

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label for="nom" class="block text-gray-700 font-medium mb-2">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" id="description" class="w-full px-4 py-2 border rounded-lg">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Enregistrer
        </button>
    </form>
</div>
@endsection