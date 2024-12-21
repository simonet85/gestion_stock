@extends('layouts.app')

@section('content')

<!-- Main Container -->
<div class="container mx-auto px-4 py-8">
    <!-- Title -->
    <h1 class="text-3xl font-extrabold mb-6 text-gray-800 flex items-center">
        🔔 Vos Notifications
    </h1>

    <!-- Mark All as Read -->
    <div class="mb-6 text-right">
        <a href="{{ route('notifications.read') }}" 
           class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg shadow-md transition-all duration-300 ease-in-out">
            Marquer toutes comme lues
        </a>
    </div>

    <!-- Notification List -->
    <ul class="space-y-4">
        @forelse($notifications as $notification)
        @php
            $produit = \App\Models\Produit::find($notification->data['alerte']['produit_id']);
        @endphp
            <li class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg shadow transition-all duration-200">
                <!-- Notification Content -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 mr-4">
                        <!-- Icon -->
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-500">
                            📩
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-700 font-medium">
                        "{{ $produit ? $produit->nom : 'Inconnu' }}" a un stock faible.
                            (Stock : {{ $notification->data['alerte']['quantite_stock'] ?? 'N/A' }}, 
                            Seuil : {{ $notification->data['alerte']['seuil_reapprovisionnement'] ?? 'N/A' }})
                        </p>
                        <span class="block text-sm text-gray-400">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                <!-- Mark as Read Button -->
                <form action="{{ route('notification.read', $notification->id) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="text-green-500 hover:text-green-600 font-semibold transition-all duration-200">
                        ✔ Marquer comme lue
                    </button>
                </form>
            </li>
        @empty
            <li class="text-gray-500 text-center py-10">
                🎉 Vous êtes à jour ! Aucune nouvelle notification.
            </li>
        @endforelse
    </ul>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $notifications->links('pagination::tailwind') }}
    </div>
</div>

@endsection
