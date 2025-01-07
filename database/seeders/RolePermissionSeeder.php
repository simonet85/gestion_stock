<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions by category
        $permissions = [
            'produits' => ['view produits', 'manage produits'],
            'categories' => ['view categories', 'manage categories'],
            'commandes' => ['view commandes', 'manage commandes'],
            'approvisionnements' => ['view approvisionnements', 'manage approvisionnements'],
            'factures' => ['view factures', 'manage factures', 'export factures'],
            'transactions' => ['view transactions', 'manage transactions', 'export transactions'],
            'users' => ['view users', 'manage users'],
            'fournisseurs' => ['view fournisseurs', 'manage fournisseurs']
        ];

        foreach ($permissions as $category => $perms) {
            foreach ($perms as $permission) {
                Permission::updateOrCreate(['name' => $permission]);
            }
        }

        // Role-specific permissions
        $rolePermissions = [
            'Administrateur' => Permission::all()->pluck('name')->toArray(),
            'Gestionnaire' => [
                'view produits', 'manage produits',
                'view categories', 'manage categories',
                'view commandes', 'manage commandes',
                'view approvisionnements', 'manage approvisionnements',
                'view factures', 'manage factures', 'export factures',
                'view transactions', 'manage transactions', 'export transactions',
                'view fournisseurs', 'manage fournisseurs'
            ],
            'Utilisateur' => [
                'view produits',
                'view categories',
                'view commandes',
                'view factures',
                'view transactions',
                'view fournisseurs'
            ]
        ];

        foreach ($rolePermissions as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }
    }
}
