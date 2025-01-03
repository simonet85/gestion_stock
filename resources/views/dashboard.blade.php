@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-100" x-data="{ sidebarOpen: true }">
    <!-- Sidebar -->
    <div :class="{'w-64': sidebarOpen, 'w-16': !sidebarOpen}" 
         class="bg-gray-800 text-white transition-all duration-300 ease-in-out">
        
        <!-- Sidebar Header -->
        <div class="p-4 flex justify-between items-center">
            <div class="flex items-center" :class="{'justify-center': !sidebarOpen}">
                <!-- <img src="#" class="h-8 w-8"> -->
                <span x-show="sidebarOpen" class="ml-2 font-semibold">Dashboard</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        @include('includes.navigation')
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
