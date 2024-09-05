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
            'id_stagiaire' => 'required|exists:stagiaires,id',
            'nom' => 'required|string|max:255',
            'niveau' => 'nullable|string',
        ]);

        $competence = Competence::create([
            'nom' => $validated['nom'],
            'niveau' => $validated['niveau'] ?? null,
            'id_stagiaire' => $validated['id_stagiaire'],
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
            'id_stagiaire' => 'sometimes|string|max:255',
            'nom' => 'nullable|string',
            'niveau' => 'nullable|numeric',
        ]);

        $competence->update(array_filter([
            'nom' => $validated['nom'] ?? $competence->name,
            'niveau' => $validated['niveau'] ?? $competence->description,
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
