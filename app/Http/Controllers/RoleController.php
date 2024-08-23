<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles',
            'description' => 'nullable|string',
            'permissions' => 'array', // Permissions liées au rôle
            'permissions.*' => 'exists:permissions,id', // Vérifier que chaque permission existe
        ]);

        // Créer le rôle
        $role = Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        // Associer les permissions si elles sont fournies
        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        return response()->json($role->load('permissions'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        // Valider la requête
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Mettre à jour le rôle
        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        // Mettre à jour les permissions si elles sont fournies
        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        return response()->json($role->load('permissions'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        // S'assurer que les rôles essentiels ne peuvent pas être supprimés
        if (in_array($role->name, ['admin', 'superviseur', 'stagiaire'])) {
            return response()->json(['error' => 'This role cannot be deleted.'], 403);
        }

        // Supprimer les permissions associées avant de supprimer le rôle
        $role->permissions()->detach();
        $role->delete();

        return response()->json(null, 204);
    }
}
