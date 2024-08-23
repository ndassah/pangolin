<?php

namespace App\Http\Controllers;

use App\Models\Administrateur;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Administrateur::with('user')->get();
        return response()->json($admins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|in:admin', // Assurer que le rôle est bien 'admin'
        ]);

        // Vérifiez que le rôle est effectivement admin avant la création
        if ($validated['role'] !== 'administrateur') {
            return response()->json(['error' => 'Invalid role'], 400);
        }

        $admin = Administrateur::create([
            'user_id' => $validated['user_id'],
        ]);

        return response()->json($admin->load('user'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = Administrateur::with('user')->findOrFail($id);
        return response()->json($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = Administrateur::findOrFail($id);

        // Administrateurs ne devraient pas être modifiés dans ce contexte
        return response()->json(['error' => 'Cannot update admin role'], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Administrateur::findOrFail($id);

        // Empêcher la suppression des administrateurs
        return response()->json(['error' => 'Cannot delete admin'], 403);
    }
}
