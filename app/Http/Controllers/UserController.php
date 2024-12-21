<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        //$users = User::role('Utilisateur')->get(); // Récupère uniquement les utilisateurs ayant le rôle "Utilisateur"
        //Récupère tous les utilisateurs avec leurs rôles
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('Utilisateur'); // Assigne le rôle "Utilisateur"

        activity('user-management')
        ->causedBy(auth()->user())
        ->performedOn($user)
        ->log('Nouveau compte enregistré avec le rôle Utilisateur');

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Name must be valid
            'email' => 'required|email|unique:users,email,' . $id, // Email must be unique except for the current user
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
    
        activity('user-management')
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('Utilisateur supprimé');
    
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    // Affiche le formulaire pour modifier les rôles
    public function editRoles($id)
    {
        $user = User::findOrFail($id); // Récupérer l'utilisateur
        $roles = Role::all(); // Récupérer tous les rôles disponibles
        return view('users.roles.edit', compact('user', 'roles'));
    }

    // Met à jour les rôles d'un utilisateur
    public function updateRoles(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldRoles = $user->getRoleNames(); // Rôles avant la modification
    
        // Synchroniser les nouveaux rôles
        $user->syncRoles($request->roles);
    
        $newRoles = $user->getRoleNames(); // Rôles après la modification
    
        activity('roles')
            ->causedBy(auth()->user()) // Utilisateur qui a fait la modification
            ->performedOn($user) // Utilisateur modifié
            ->withProperties([
                'old_roles' => $oldRoles,
                'new_roles' => $newRoles,
            ])
            ->log('Modification des rôles');
        
        return redirect()->route('users.index')->with('success', 'Rôles mis à jour avec succès.');
    }
    
}
