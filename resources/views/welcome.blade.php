<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Système de gestion des stocks</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Sticky Navigation -->
        <nav class="sticky top-0 z-50 bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <span class="text-2xl font-bold text-blue-600">StockPro</span>
            </div>
            
            @if (Route::has('login'))
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 transition duration-200">
                           Tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 text-gray-600 hover:text-gray-900 transition duration-200">
                           Se connecter
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-4 py-2 rounded-lg border border-blue-500 text-blue-500 hover:bg-blue-50 transition duration-200">
                               S'inscrire
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</nav>


        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                            Gérez vos stocks de manière efficace
                        </h1>
                        <p class="text-lg text-gray-600 mb-8">
                        Optimisez votre processus de gestion de stock avec notre solution complète. Suivez vos stocks, gérez vos commandes et développez votre entreprise.
                        </p>
                        <div class="space-x-4">
                            <a href="{{ route('register') }}" 
                               class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                               Commencer Maintenant
                            </a>
                            <a href="#features" 
                               class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                               En Savoir Plus
                            </a>
                        </div>
                    </div>
                    <div class="relative">
                        <img src="/images/inventory.png" alt="Gestion des stocks" class="w-1/2 mx-auto">
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="bg-white py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900">Principales Fonctionnalités</h2>
                    <p class="mt-4 text-lg text-gray-600">Tout ce dont vous avez besoin pour gérer efficacement votre inventaire.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 bg-gray-50 rounded-xl">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Suivi en temps réel</h3>
                        <p class="text-gray-600">Surveillez vos niveaux de stock en temps réel avec des mises à jour automatisées.</p>
                    </div>
                    <!-- Add more feature cards as needed -->
                    <div class="p-6 bg-gray-50 rounded-xl">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Gestion des stocks</h3>
                        <p class="text-gray-600">Gérez vos stocks de maniere efficace et optimisee.</p>
                    </div>
                    <div class="p-6 bg-gray-50 rounded-xl">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>        
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Commandes</h3>
                        <p class="text-gray-600">Gérez vos commandes de maniere efficace et optimisee.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- sticky footer  -->
    <footer class="bg-gray-800 text-white py-4 top-0 z-50 sticky w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center">&copy; 2025 StockPro. Tous droits reservés.</p>
        </div>
    </footer>
</body>
</html>
