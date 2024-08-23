<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stages = Stage::with(['stagiaires', 'superviseur'])->get();
        return response()->json($stages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_service' => 'required|string|max:255',
            'date_debut'=>'date',
            'date_fin'=>'date|after:date_debut',
        ]);

        $stage = Stage::create([
            'id_service' => $validated['id_service'],
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'] ?? null,
        ]);

        return response()->json($stage->load(['superviseur']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stage = Stage::with(['stagiaires', 'superviseur'])->findOrFail($id);
        return response()->json($stage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stage = Stage::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $stage->update(array_filter([
            'title' => $validated['title'] ?? $stage->title,
            'description' => $validated['description'] ?? $stage->description,
            'start_date' => $validated['start_date'] ?? $stage->start_date,
            'end_date' => $validated['end_date'] ?? $stage->end_date,
        ]));

        return response()->json($stage->load(['superviseur']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stage = Stage::findOrFail($id);
        $stage->delete();

        return response()->json(null, 204);
    }
}
