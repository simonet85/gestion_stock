@extends('layouts.app')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-xl w-full px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Méthode Non Autorisée</h1>
                    <p class="text-gray-600 mb-8">La méthode utilisée pour cette requête n'est pas autorisée.</p>

                    <div class="space-y-4">
                        <a href="{{ url()->previous() }}" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 transition duration-150 mr-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
