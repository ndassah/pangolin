<?php

namespace App\Http\Controllers;

use App\Models\Rapport;
use Illuminate\Http\Request;

class RapportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rapports = Rapport::with(['stagiaire', 'superviseur'])->get();
        return response()->json($rapports);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contenu' => 'required|string',
            'stagiaire_id' => 'required|exists:stagiaires,id',
            'superviseur_id' => 'required|exists:superviseurs,id',
        ]);

        $rapport = Rapport::create([
            'contenu' => $validated['content'],
            'stagiaire_id' => $validated['stagiaire_id'],
            'superviseur_id' => $validated['superviseur_id'],
        ]);

        return response()->json($rapport->load(['stagiaire', 'superviseur']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rapport = Rapport::with(['stagiaire', 'superviseur'])->findOrFail($id);
        return response()->json($rapport);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rapport = Rapport::findOrFail($id);

        $validated = $request->validate([
           // 'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        $rapport->update(array_filter([
           // 'title' => $validated['title'] ?? $rapport->title,
            'content' => $validated['content'] ?? $rapport->content,
        ]));

        return response()->json($rapport->load(['stagiaire', 'superviseur']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rapport = Rapport::findOrFail($id);
        $rapport->delete();

        return response()->json(null, 204);
    }
}
