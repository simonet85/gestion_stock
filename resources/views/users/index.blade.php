@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Liste des Utilisateurs et leurs Rôles</h1>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Rôle(s)</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $user->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @foreach ($user->roles as $role)
                        <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded">
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <a href="{{ route('users.roles.edit', $user->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Modifier les Rôles
                        </a>
                        <a href="{{ route('users.edit', $user->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Modifier
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">
            {{ $users->links() }} {{-- Generates pagination links with Tailwind styles --}}
        </div>
    </div>
</div>
@endsection
