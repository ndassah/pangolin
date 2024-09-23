<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Tache;
use App\Models\Stagiaire;
use Illuminate\Http\Request;

class TacheController extends Controller
{
   
    // Créer une nouvelle tâche (sans attribution directe à un stagiaire)

    public function afficherToutesLesTaches()
    {
        try {
            $taches = Tache::with('activite', 'superviseur')->get();
            return response()->json(['taches' => $taches], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération des tâches.', 'error' => $e->getMessage()], 500);
        }
    }
    
    

    
    public function creerEtAttribuerTache(Request $request)
{
    try {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255|unique:taches',
            'description' => 'required|string|max:255',
            'duree_prevue' => 'required|string',
            'activite_id' => 'required|exists:activites,id',
            'id_superviseur' => 'required|exists:superviseurs,id',
        ]);

        $tache = new Tache();
        $tache->titre = $validatedData['titre'];
        $tache->description = $validatedData['description'];
        $tache->duree_prevue = $validatedData['duree_prevue'];
        $tache->activite_id = $validatedData['activite_id'];
        $tache->id_superviseur = $validatedData['id_superviseur'];
        $tache->status = 'en cours';
        $tache->save();

        // Mise à jour du pourcentage de l'activité liée après la création de la tâche
        $this->mettreAJourPourcentageActivite($tache->activite_id);

        return response()->json(['message' => 'Tâche créée avec succès.'], 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erreur lors de la création de la tâche.', 'error' => $e->getMessage()], 500);
    }
}


    // Validation de la tâche par le superviseur avec une note
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

    // Mettre à jour une tâche existante
    public function mettreAJourTache(Request $request, $tache_id)
    {
        $tache = Tache::find($tache_id);

        if (!$tache) {
            return response()->json(['message' => 'Tâche introuvable'], 404);
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'duree_prevue' => 'required|date_format:H:i',
            'statut' => 'required|in:en cours,terminée',
            'note' => 'nullable|numeric|min:0|max:100',
        ]);

        $tache->titre = $request->input('titre');
        $tache->description = $request->input('description');
        $tache->duree_prevue = $request->input('duree_prevue');
        $tache->status = $request->input('statut');
        $tache->note = $request->input('note');
        $tache->save();

        // Mise à jour du pourcentage de l'activité liée si nécessaire
        $this->mettreAJourPourcentageActivite($tache->id_activites);

        return response()->json(['message' => 'Tâche mise à jour avec succès', 'tache' => $tache], 200);
    }

    // Supprimer une tâche
    public function supprimerTache($tache_id)
    {
        $tache = Tache::find($tache_id);

        if (!$tache) {
            return response()->json(['message' => 'Tâche introuvable'], 404);
        }

        $activite_id = $tache->id_activites;
        $tache->delete();

        // Mise à jour du pourcentage de l'activité liée après la suppression
        $this->mettreAJourPourcentageActivite($activite_id);

        return response()->json(['message' => 'Tâche supprimée avec succès'], 200);
    }

    // Afficher toutes les tâches d'un stagiaire (via ses travaux)
    public function afficherTachesStagiaire($stagiaire_id)
    {
        $taches = Tache::whereHas('travaux', function ($query) use ($stagiaire_id) {
            $query->where('stagiaire_id', $stagiaire_id);
        })->get();

        return response()->json($taches, 200);
    }

    // Afficher toutes les tâches en cours
    public function afficherTachesEnCours()
    {
        $tachesEnCours = Tache::where('status', 'en cours')->with('travaux')->get();

        return response()->json($tachesEnCours, 200);
    }

    // Afficher toutes les tâches terminées
    public function afficherTachesTerminees()
    {
        $tachesTerminees = Tache::where('status', 'terminée')->with('travaux')->get();

        return response()->json($tachesTerminees, 200);
    }

    // Mettre à jour le pourcentage de l'activité associée
    private function mettreAJourPourcentageActivite($activite_id)
    {
        $activite = Activite::findOrFail($activite_id);
        $totalTaches = $activite->taches()->count();
        $tachesTerminees = $activite->taches()->where('status', 'terminée')->count();

        if ($totalTaches > 0) {
            $activite->pourcentage = ($tachesTerminees / $totalTaches) * 100;
        } else {
            $activite->pourcentage = 0;
        }

        $activite->save();
    }
}
