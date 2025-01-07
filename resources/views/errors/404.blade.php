@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-xl w-full px-4">
            <div class="text-center">
                <div class="text-6xl font-bold text-blue-600 mb-4">404</div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Page non trouvée</h1>
                <p class="text-gray-600 mb-8">Désolé, la page que vous recherchez n'existe pas ou a été déplacée.</p>
                
                <img src="{{ asset('images/404.svg') }}" alt="404 Illustration" class="w-64 mx-auto mb-8">
                
                <div class="space-y-4">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
