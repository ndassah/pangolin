<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use Illuminate\Http\Request;

class ActiviteeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $activitees = Activite::with(['taches', 'service'])->get()->map(function ($activitee) {
        // Récupérer le nombre total de tâches
        $totalTaches = $activitee->taches->count();
        // Récupérer le nombre de tâches terminées
        $tachesTerminees = $activitee->taches->where('statut', 'terminée')->count();
        // Calculer le pourcentage réalisé
        $pourcentageRealise = $totalTaches > 0 ? ($tachesTerminees / $totalTaches) * 100 : 0;

        return [
            'id' => $activitee->id, // Ajouter l'ID de l'activité
            'nom_activites' => $activitee->nom_activites,
            'description' => $activitee->description,
            'service' => $activitee->service ? $activitee->service->nom_services : 'Non défini',
            'nombre_total_taches' => $totalTaches, // Ajouter le nombre total de tâches
            'pourcentageRealise' => number_format($pourcentageRealise, 2) . '%'
        ];
    });

    return response()->json($activitees);
}

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_activites' => 'required|string|max:100|unique:activites',
            'id_service'=>'required|numeric',
            'description' => 'required|string',
        ]);

        $activitee = Activite::create($validated);

        return response()->json($activitee->load('taches'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $activitee = Activite::with('tache', 'stagiaire')->findOrFail($id);
        return response()->json($activitee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $activitee = Activite::findOrFail($id);

        $validated = $request->validate([
            'nom_activites' => 'sometimes|string|max:100',
            'id_service'=>'required|numeric',
            'description' => 'nullable|string',
        ]);

        $activitee->update(array_filter($validated));

        return response()->json($activitee->load('tache'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activitee = Activite::findOrFail($id);
        $activitee->delete();

        return response()->json(null, 204);
    }
}
