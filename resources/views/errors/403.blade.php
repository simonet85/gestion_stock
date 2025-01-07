@extends('layouts.app')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-xl w-full px-4">
        <div class="text-center">
            <div class="text-6xl font-bold text-red-600 mb-4">403</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Accès Refusé</h1>
            <p class="text-gray-600 mb-8">Désolé, vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
            
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            Si vous pensez qu'il s'agit d'une erreur, veuillez contacter votre administrateur.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <a href="{{ url()->previous() }}" 
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </div>
</div>

@endsection