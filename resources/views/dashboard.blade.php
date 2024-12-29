@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-100" x-data="{ sidebarOpen: true }">
    <!-- Sidebar -->
    <div :class="{'w-64': sidebarOpen, 'w-16': !sidebarOpen}" 
         class="bg-gray-800 text-white transition-all duration-300 ease-in-out">
        
        <!-- Sidebar Header -->
        <div class="p-4 flex justify-between items-center">
            <div class="flex items-center" :class="{'justify-center': !sidebarOpen}">
                <img src="/logo.svg" class="h-8 w-8" alt="Logo">
                <span x-show="sidebarOpen" class="ml-2 font-semibold">Dashboard</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-4">
            <div class="px-4 space-y-2">
                <!-- Commandes Section -->
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center w-full p-2 text-white hover:bg-gray-700 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3">Commandes</span>
                        <svg x-show="sidebarOpen" class="w-4 h-4 ml-auto" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 mt-2 space-y-2">
                        <a href="{{ route('commandes.index') }}" class="flex items-center p-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg">Liste</a>
                        <a href="{{ route('commandes.create') }}" class="flex items-center p-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg">Créer</a>
                    </div>
                </div>

                <!-- Fournisseurs Section -->
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center w-full p-2 text-white hover:bg-gray-700 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3">Fournisseurs</span>
                        <svg x-show="sidebarOpen" class="w-4 h-4 ml-auto" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 mt-2 space-y-2">
                        <a href="{{ route('fournisseurs.index') }}" class="flex items-center p-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg">Liste</a>
                        <a href="{{ route('fournisseurs.create') }}" class="flex items-center p-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg">Ajouter</a>
                    </div>
                </div>

                <!-- Categories Section -->
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center w-full p-2 text-white hover:bg-gray-700 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3">Catégories</span>
                        <svg x-show="sidebarOpen" class="w-4 h-4 ml-auto" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 mt-2 space-y-2">
                        <a href="{{ route('categories.index') }}" class="flex items-center p-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg">Liste</a>
                        <a href="{{ route('categories.create') }}" class="flex items-center p-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg">Ajouter</a>
                    </div>
                </div>

                <!-- Approvisionnements Section -->
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center w-full p-2 text-white hover:bg-gray-700 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3">Approvisionnements</span>
                        <svg x-show="sidebarOpen" class="w-4 h-4 ml-auto" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 mt-2 space-y-2">
                        <a href="{{ route('approvisionnements.index') }}" class="flex items-center p-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg">Liste</a>
                        <a href="{{ route('approvisionnements.create') }}" class="flex items-center p-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg">Ajouter</a>
                    </div>
                </div>

                <!-- Notifications Section -->
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center w-full p-2 text-white hover:bg-gray-700 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.5V11a6 6 0 00-12 0v3.5c0 .828-.332 1.582-.895 2.095L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0h-6"/>
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3">Notifications</span>
                        <svg x-show="sidebarOpen" class="w-4 h-4 ml-auto" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 mt-2 space-y-2">
                        <a href="{{ route('notifications') }}" class="flex items-center p-2 text-sm text-gray-300 hover:bg-gray-700 rounded-lg">Voir tout</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ">
        <!-- Your existing dashboard content here -->
        @include('includes.dashboard-content')
    </div>
</div>
<!-- sticky footer  -->
<!-- <footer class="bg-gray-800 text-white py-4 text-center fixed bottom-0 w-full">
    <p>&copy; 2024 GestStock. Tout droit reservé.</p>
 </footer> -->
@endsection
