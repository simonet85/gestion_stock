<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = User::role('Gestionnaire')->get();
        return view('managers.index', compact('managers'));
    }

    public function create()
    {
        return view('managers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $manager = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $manager->assignRole('Gestionnaire'); // Assigne le rôle "Gestionnaire"

        return redirect()->route('managers.index')->with('success', 'Gestionnaire ajouté avec succès.');
    }

    public function destroy(User $manager)
    {
        $manager->delete();
        return redirect()->route('managers.index')->with('success', 'Gestionnaire supprimé avec succès.');
    }
}
