<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Travaux;
use App\Models\Tache;
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
        $tache = Tache::findOrFail($tache_id);
        $totalTravaux = $tache->travaux()->count();
        $travauxTermines = $tache->travaux()->where('status', 'terminé')->count();

        if ($totalTravaux > 0) {
            $tache->pourcentage = ($travauxTermines / $totalTravaux) * 100;
        } else {
            $tache->pourcentage = 0;
        }

        $tache->save();

        // Mise à jour du pourcentage de l'activité liée
        $this->mettreAJourPourcentageActivite($tache->id_activites);
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
}
