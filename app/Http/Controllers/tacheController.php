<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use App\Models\Stagiaire;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    // Créer une nouvelle tâche et l'attribuer à un stagiaire
    public function creerEtAttribuerTache(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'duree_prevue' => 'required|integer',
            'stagiaire_id' => 'required|exists:stagiaires,id',
        ]);

        $tache = new Tache();
        $tache->description = $validatedData['description'];
        $tache->duree_prevue = $validatedData['duree_prevue'];
        $tache->stagiaire_id = $validatedData['stagiaire_id'];
        $tache->status = 'en cours';
        $tache->save();

        return response()->json(['message' => 'Tâche créée et attribuée avec succès.'], 201);
    }

    // Le stagiaire marque la tâche comme terminée et envoie un feedback
    public function terminerTache(Request $request, $id)
    {
        $validatedData = $request->validate([
            'feedback' => 'required|string|max:500',
            'duree_effective' => 'required|integer',
        ]);

        $tache = Tache::find($id);

        if (!$tache) {
            return response()->json(['message' => 'Tâche introuvable'], 404);
        }

        $tache->feedback = $validatedData['feedback'];
        $tache->duree_effective = $validatedData['duree_effective'];
        $tache->status = 'terminée';
        $tache->save();

        return response()->json(['message' => 'Tâche marquée comme terminée.'], 200);
    }

    // Le superviseur valide la tâche comme bien faite et attribue une note
    public function validerTache(Request $request, $id)
    {
        $validatedData = $request->validate([
            'note' => 'required|integer|min:0|max:100',
            'validation_superviseur' => 'required|boolean',
        ]);

        $tache = Tache::find($id);

        if (!$tache) {
            return response()->json(['message' => 'Tâche introuvable'], 404);
        }

        $tache->note = $validatedData['note'];
        $tache->validation_superviseur = $validatedData['validation_superviseur'];
        $tache->save();

        return response()->json(['message' => 'Tâche validée avec succès.'], 200);
    }
}