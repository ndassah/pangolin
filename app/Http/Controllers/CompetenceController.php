<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competences = Competence::with('stagiaire')->get();
        return response()->json($competences);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stagiaire_id' => 'required|exists:stagiaires,id',
        ]);

        $competence = Competence::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'stagiaire_id' => $validated['stagiaire_id'],
        ]);

        return response()->json($competence->load('stagiaire'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $competence = Competence::with('stagiaire')->findOrFail($id);
        return response()->json($competence);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $competence = Competence::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $competence->update(array_filter([
            'name' => $validated['name'] ?? $competence->name,
            'description' => $validated['description'] ?? $competence->description,
        ]));

        return response()->json($competence->load('stagiaire'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $competence = Competence::findOrFail($id);
        $competence->delete();

        return response()->json(null, 204);
    }
}
