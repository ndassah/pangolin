<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StagiaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les superviseurs avec leur nom depuis la relation avec la table users
        $stagiaires = Stagiaire::with('user')->get();
    
        // Retourner uniquement l'id des superviseurs et le nom associé au user_id
        $formattedStagiaires = $stagiaires->map(function ($stagiaire) {
            return [
                'id' => $stagiaire->id,
                'nom' => $stagiaire->user->nom, // Nom du superviseur récupéré depuis la relation User
            ];
        });
    
        return response()->json($formattedStagiaires);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
        ]);

        $stagiaire = Stagiaire::create([
            'uuid'=> Str::uuid(),
            'user_id' => $validated['user_id'],
            'service_id' => $validated['service_id'],
        ]);

        return response()->json($stagiaire->load(['user', 'service']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stagiaire = Stagiaire::with(['user', 'service', 'activitees', 'rapports'])->findOrFail($id);
        return response()->json($stagiaire);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stagiaire = Stagiaire::findOrFail($id);

        $validated = $request->validate([
            'service_id' => 'sometimes|exists:services,id',
        ]);

        $stagiaire->update(array_filter([
            'service_id' => $validated['service_id'] ?? $stagiaire->service_id,
        ]));

        return response()->json($stagiaire->load(['user', 'service']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stagiaire = Stagiaire::findOrFail($id);
        $stagiaire->delete();

        return response()->json(null, 204);
    }
}
