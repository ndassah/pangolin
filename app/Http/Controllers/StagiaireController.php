<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StagiaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stagiaires = Stagiaire::with(['user', 'stage', /*'activitees','rapports'*/ ])->get();
        return response()->json($stagiaires);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'stage_id' => 'required|exists:stages,id',
            'service_id' => 'required|exists:services,id',
        ]);

        $stagiaire = Stagiaire::create([
            'uuid'=> Str::uuid(),
            'user_id' => $validated['user_id'],
            'stage_id' => $validated['stage_id'],
            'service_id' => $validated['service_id'],
        ]);

        return response()->json($stagiaire->load(['user', 'stage', 'service']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stagiaire = Stagiaire::with(['user', 'stage', 'service', 'activitees', 'rapports'])->findOrFail($id);
        return response()->json($stagiaire);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stagiaire = Stagiaire::findOrFail($id);

        $validated = $request->validate([
            'stage_id' => 'sometimes|exists:stages,id',
            'service_id' => 'sometimes|exists:services,id',
        ]);

        $stagiaire->update(array_filter([
            'stage_id' => $validated['stage_id'] ?? $stagiaire->stage_id,
            'service_id' => $validated['service_id'] ?? $stagiaire->service_id,
        ]));

        return response()->json($stagiaire->load(['user', 'stage', 'service']));
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
