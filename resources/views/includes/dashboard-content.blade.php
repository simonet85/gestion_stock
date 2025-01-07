<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord</h1>
        <!-- <div class="relative">
            <button id="notifications-btn" class="bg-white p-2 rounded-full hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.5V11a6 6 0 00-12 0v3.5c0 .828-.332 1.582-.895 2.095L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0h-6" />
                </svg>
            </button>
        </div> -->
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Users Management Card -->
    @canany(['view users', 'manage users'])
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">Gestion des Utilisateurs</h2>
            </div>
            <div class="space-y-3">
                @can('view users')
                <a href="{{ route('users.index') }}" class="flex items-center p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                    <span class="mr-3">👥</span>
                    Liste des utilisateurs
                </a>
                @endcan
                @can('manage users')
                <a href="{{ route('users.create') }}" class="flex items-center p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                    <span class="mr-3">➕</span>
                    Ajouter un utilisateur
                </a>
                @endcan
            </div>
        </div>
    </div>
    @endcanany

    <!-- Products Management Card -->
    @canany(['view produits', 'manage produits'])
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">Gestion des Produits</h2>
            </div>
            <div class="space-y-3">
                @can('view produits')
                <a href="{{ route('produits.index') }}" class="flex items-center p-3 text-gray-700 hover:bg-green-50 rounded-lg transition-colors duration-200">
                    <span class="mr-3">📦</span>
                    Liste des produits
                </a>
                @endcan
                @can('manage produits')
                <a href="{{ route('produits.create') }}" class="flex items-center p-3 text-gray-700 hover:bg-green-50 rounded-lg transition-colors duration-200">
                    <span class="mr-3">➕</span>
                    Ajouter un produit
                </a>
                @endcan
            </div>
        </div>
    </div>
    @endcanany

    <!-- Supplier Management Card -->
    @canany(['view fournisseurs', 'manage fournisseurs'])
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <svg class="w-5 h-5 md:w-6 lg:w-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">Gestion des Fournisseurs</h2>
            </div>
            <div class="space-y-3">
                @can('view fournisseurs')
                <a href="{{ route('fournisseurs.index') }}" class="flex items-center p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                    <span class="mr-3">
                        <svg class="w-5 h-5 md:w-6 lg:w-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </span>
                    Liste des fournisseurs
                </a>
                @endcan
                @can('manage fournisseurs')
                <a href="{{ route('fournisseurs.create') }}" class="flex items-center p-3 text-gray-700 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                    <span class="mr-3">➕</span>
                    Ajouter un fournisseur
                </a>
                @endcan
            </div>
        </div>
    </div>
    @endcanany
</div>


    <!-- Quick Stats Section -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-blue-500 text-white rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-2">Total Utilisateurs</h3>
            <p class="text-3xl font-bold">{{ $data['totalUsers'] ?? 0 }}</p>
        </div>
        <div class="bg-green-500 text-white rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-2">Produits en Stock</h3>
            <p class="text-3xl font-bold">{{ $data['totalProducts'] ?? 0 }}</p>
        </div>
        <div class="bg-yellow-500 text-white rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-2">Commandes en Cours</h3>
            <p class="text-3xl font-bold">{{ $data['pendingOrders'] ?? 0 }}</p>
        </div>
        <div class="bg-purple-500 text-white rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-2">Fournisseurs Actifs</h3>
            <p class="text-3xl font-bold">{{ $data['activeSuppliers'] ?? 0 }}</p>
        </div>
    </div>

    
    <!-- Recent Orders Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mt-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Commandes Récentes</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($data['recentOrders'] ?? [] as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->date_commande }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $order->statut === 'En cours' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($order->statut === 'Validé' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $order->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($order->montant_total, 2) }} CFA</td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <a href="{{ route('commandes.edit', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.hover\\:shadow-md');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('transform', 'scale-105');
        });
        card.addEventListener('mouseleave', function() {
            this.classList.remove('transform', 'scale-105');
        });
    });
});
</script>

