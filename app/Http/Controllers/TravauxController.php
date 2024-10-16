<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Travaux;
use App\Models\Tache;
use App\Events\TravailCree;
use Illuminate\Http\Request;

class TravauxController extends Controller
{
    // Marquer un travail comme terminé
    public function marquerTravauxTermine(Request $request, $id)
    {
        // Trouver le travail
        $travaux = Travaux::findOrFail($id);

        // Marquer le travail comme terminé
        $travaux->status = 'terminé';
        $travaux->save();

        // Mise à jour du pourcentage de la tâche
        $this->mettreAJourPourcentageTache($travaux->tache_id);

        return response()->json(['message' => 'Travail marqué comme terminé.'], 200);
    }

    // Fonction pour mettre à jour le pourcentage d'une tâche
    private function mettreAJourPourcentageTache($tache_id)
{
    // Vérification que la tâche existe
    $tache = Tache::find($tache_id);

    if ($tache) {
        $totalTravaux = $tache->travaux()->count();
        $travauxTermines = $tache->travaux()->where('status', 'terminé')->count();

        $tache->pourcentage = $totalTravaux > 0 ? ($travauxTermines / $totalTravaux) * 100 : 0;
        $tache->save();

        // Mettre à jour l'activité liée à la tâche
        $this->mettreAJourPourcentageActivite($tache->id_activites);
    }
}


    // Fonction pour mettre à jour le pourcentage d'une activité
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

    public function creerTravaux(Request $request)
{
    // Validation des données entrantes
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255|unique:travaux',
        'description' => 'nullable|string',
        'tache_id' => 'required|exists:taches,id', // La tâche doit exister
        'status' => 'nullable|string|in:en cours,terminé', // Statut optionnel
        'stagiaire_id' => 'required|exists:stagiaires,id', 
    ]);

    // Créer un nouveau travail avec les données validées
    $travail = new Travaux();
    $travail->nom = $validatedData['nom'];
    $travail->description = $validatedData['description'] ?? null;
    $travail->tache_id = $validatedData['tache_id'];
    $travail->status = $validatedData['status'] ?? 'en cours'; // Par défaut en cours
    $travail->stagiaire_id = $validatedData['stagiaire_id'];
    $travail->save();

    // Mise à jour du pourcentage de la tâche
    $this->mettreAJourPourcentageTache($travail->tache_id);

    event(new TravailCree($travail));//evenement de creation

    return response()->json([
        'message' => 'Travail créé avec succès.',
        'travail' => $travail
    ], 201);
}



    // Afficher tous les travaux
    public function afficherTousLesTravaux()
    {
        // Récupérer tous les travaux
        $travaux = Travaux::all();

        // Retourner une réponse JSON avec la liste des travaux
        return response()->json([
            'travaux' => $travaux
        ], 200);
    }
}
