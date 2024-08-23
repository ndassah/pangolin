<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taches = Tache::with(['stagiaire', 'superviseur'])->get();
        return response()->json($taches);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'date',
            'date_fin'=>'date|after:date_debut',
            'status'=>'required|string',
            'stagiaire_id' => 'required|exists:stagiaires,id',
            'id_activites'=>'required|exists:activites,id',
            'id_superviseur' => 'required|exists:superviseurs,id',
        ]);

        $tache = Tache::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'] ?? null,
            'status' => $validated['status'],
            'stagiaire_id' => $validated['stagiaire_id'],
            'id_activites' => $validated['id_activites'],
            'id_superviseur' => $validated['id_superviseur'],
        ]);

        return response()->json($tache->load(['stagiaire', 'superviseur']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tache = Tache::with(['stagiaire', 'superviseur'])->findOrFail($id);
        return response()->json($tache);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tache = Tache::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'date',
            'date_fin'=>'date|after:date_debut',
            'status'=>'required|string',
            'stagiaire_id' => 'required|exists:stagiaires,id',
            'id_activites'=>'required|exists:activites,id',
            'id_superviseur' => 'required|exists:superviseurs,id',
        ]);

        $tache->update(array_filter([
            'titre' => $validated['titre'] ?? $tache->titre,
            'description' => $validated['description'] ?? $tache->description,
           'date_debut' => $validated['date_debut'] ?? $tache->date_debut,
            'date_fin' => $validated['date_fin'] ?? null,
            'status' => $validated['status'] ?? $tache->status,
            'stagiaire_id' => $validated['stagiaire_id'] ?? $tache->stagiaire_id,
            'id_activites' => $validated['id_activites'] ?? $tache->id_activites,
            'id_superviseur' => $validated['id_superviseur'] ?? $tache->id_superviseur,
        ]));

        return response()->json($tache->load(['stagiaire', 'superviseur']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tache = Tache::findOrFail($id);
        $tache->delete();

        return response()->json(null, 204);
    }
}
