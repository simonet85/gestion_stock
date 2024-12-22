@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Tableau de Bord</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Users Module -->
       
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Gestion des Utilisateurs</h2>
            <ul>
                <li>
                    <a href="{{ route('users.index') }}" class="text-blue-600 hover:underline">Liste des utilisateurs</a>
                </li>
                <li>
                    <a href="{{ route('users.create') }}" class="text-blue-600 hover:underline">Ajouter un utilisateur</a>
                </li>
            </ul>
        </div>
       

        <!-- Administrators Module -->
     
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Gestion des Administrateurs</h2>
            <ul>
                <li>
                    <a href="{{ route('admins.index') }}" class="text-blue-600 hover:underline">Liste des administrateurs</a>
                </li>
                <li>
                    <a href="{{ route('admins.create') }}" class="text-blue-600 hover:underline">Ajouter un administrateur</a>
                </li>
            </ul>
        </div>
    

        <!-- Managers Module -->
       
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Gestion des Gestionnaires</h2>
            <ul>
                <li>
                    <a href="{{ route('managers.index') }}" class="text-blue-600 hover:underline">Liste des gestionnaires</a>
                </li>
                <li>
                    <a href="{{ route('managers.create') }}" class="text-blue-600 hover:underline">Ajouter un gestionnaire</a>
                </li>
            </ul>
        </div>
    

        <!-- Products Module -->
      
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Gestion des Produits</h2>
            <ul>
                <li>
                    <a href="{{ route('produits.index') }}" class="text-blue-600 hover:underline">Liste des produits</a>
                </li>
                <li>
                    <a href="{{ route('produits.create') }}" class="text-blue-600 hover:underline">Ajouter un produit</a>
                </li>
            </ul>
        </div>
   

        <!-- Suppliers Module -->
    
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Gestion des Fournisseurs</h2>
            <ul>
                <li>
                    <a href="{{ route('fournisseurs.index') }}" class="text-blue-600 hover:underline">Liste des fournisseurs</a>
                </li>
                <li>
                    <a href="{{ route('fournisseurs.create') }}" class="text-blue-600 hover:underline">Ajouter un fournisseur</a>
                </li>
            </ul>
        </div>
  

        <!-- Categories Module -->
      
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Gestion des Catégories</h2>
            <ul>
                <li>
                    <a href="{{ route('categories.index') }}" class="text-blue-600 hover:underline">Liste des catégories</a>
                </li>
                <li>
                    <a href="{{ route('categories.create') }}" class="text-blue-600 hover:underline">Ajouter une catégorie</a>
                </li>
            </ul>
        </div>

        <!-- Notifications Module-->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Notifications</h2>
            <ul>
                <li>
                    <a href="{{ route('notifications') }}" class="text-blue-600 hover:underline">Voir et marquer toutes les notifications comme lues</a>
                </li>
            </ul>
        </div>

        <!--Approvisionnements Module -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Gestion des Approvisionnements</h2>
            <ul>
                <li>
                    <a href="{{ route('approvisionnements.index') }}" class="text-blue-600 hover:underline">Liste des approvisionnements</a>
                </li>
                <li>
                    <a href="{{ route('approvisionnements.create') }}" class="text-blue-600 hover:underline">Ajouter un approvisionnement</a>
                </li>
            </ul>
        </div>
        
    </div>
</div>
@endsection
