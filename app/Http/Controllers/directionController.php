<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\Request;

class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directions = Direction::all();//with('services')->get();
        return response()->json($directions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_direction' => 'required|string|max:100',
        ]);

        $direction = Direction::create($validated);

        return response()->json($direction->load('services'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $direction = Direction::with('services')->findOrFail($id);
        return response()->json($direction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $direction = Direction::findOrFail($id);

        $validated = $request->validate([
            'nom_direction' => 'sometimes|string|max:100',
        ]);

        $direction->update(array_filter($validated));

        return response()->json($direction->load('services'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $direction = Direction::findOrFail($id);
        $direction->delete();

        return response()->json(null, 204);
    }

    public function etude($id)
{
    // Récupérer la direction et ses activités
    $direction = Direction::with('services.activites')->findOrFail($id);
    
    // Calculer le taux de réalisation pour chaque activité
    $data = $direction->services->flatMap(function ($service) {
        return $service->activites->map(function ($activite) {
            return [
                'nom' => $activite->nom,
                'taux_realisation' => $activite->taches->where('status', 'terminée')->count() / $activite->taches->count() * 100,
                'nombre_activites' => $activite->taches->count(),
            ];
        });
    });
    
    return response()->json($data);
}

}
