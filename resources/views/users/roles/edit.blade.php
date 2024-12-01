@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Modifier les Rôles pour {{ $user->name }}</h1>

    <form action="{{ route('users.roles.update', $user->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Rôles Disponibles</label>
            @foreach ($roles as $role)
            <div class="flex items-center mb-2">
                <input type="checkbox" name="roles[]" value="{{ $role->name }}" id="role-{{ $role->id }}" class="form-checkbox h-5 w-5 text-blue-600" {{ $user->roles->contains('name', $role->name) ? 'checked' : '' }}>
                <label for="role-{{ $role->id }}" class="ml-2 text-gray-700">{{ $role->name }}</label>
            </div>
            @endforeach
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Enregistrer les Rôles
            </button>
        </div>
    </form>
</div>
@endsection
