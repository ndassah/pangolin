<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\Tache;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EvaluationController extends Controller
{
    public function evaluerStagiaire($stagiaire_id)
    {
        $stagiaire = Stagiaire::find($stagiaire_id);

        if (!$stagiaire) {
            return response()->json(['message' => 'Stagiaire introuvable'], 404);
        }

        $taches = $stagiaire->taches;

        if ($taches->isEmpty()) {
            return response()->json([
                'message' => 'Aucune tâche associée à ce stagiaire.',
                'total_taches' => 0,
                'taches_bien_faites' => 0,
                'temps_total_prevu' => 0,
                'temps_total_effectif' => 0,
                'note_finale' => 0
            ], 200);
        }

        $totalTaches = $taches->count();
        $tachesBienFaites = $taches->where('note', '>=', 50)
                                    ->where('validation_superviseur', true)
                                    ->count();

        // Utilisation de la durée en minutes directement si les colonnes sont au format de temps
        $totalTempsPrevus = $taches->sum('duree_prevue');
        $totalTempsEffectifs = $taches->sum('duree_effective');

        // Calcul des scores
        $scoreTaches = ($totalTaches > 0) ? ($tachesBienFaites / $totalTaches) * 100 : 0;
        $scoreTemps = ($totalTempsPrevus > 0 && $totalTempsEffectifs > 0) ? min(($totalTempsPrevus / $totalTempsEffectifs) * 100, 100) : 100;

        // Poids des critères
        $poidsTaches = 0.4; // 40% du score total
        $poidsTemps = 0.3;  // 30% du score total
        $poidsQualite = 0.3; // 30% du score total

        // Score de qualité basé sur les notes
        $scoreQualite = is_numeric($taches->avg('note')) ? $taches->avg('note') : 0;

        // Calcul de la note finale
        $noteFinale = ($scoreTaches * $poidsTaches) + ($scoreTemps * $poidsTemps) + ($scoreQualite * $poidsQualite);

        return response()->json([
            'total_taches' => $totalTaches,
            'taches_bien_faites' => $tachesBienFaites,
            'temps_total_prevu' => $totalTempsPrevus,
            'temps_total_effectif' => $totalTempsEffectifs,
            'note_finale' => round($noteFinale, 2)
        ], 200);
    }

    public function imprimerRapportEvaluation($stagiaire_id)
    {
        $stagiaire = Stagiaire::find($stagiaire_id);

        if (!$stagiaire) {
            return response()->json(['message' => 'Stagiaire introuvable'], 404);
        }

        $taches = $stagiaire->taches;

        $totalTaches = $taches->count();
        $tachesBienFaites = $taches->where('note', '>=', 70)
                                    ->where('validation_superviseur', true)
                                    ->count();

        // Calcul des durées
        $totalTempsPrevus = $taches->sum('duree_prevue');
        $totalTempsEffectifs = $taches->sum('duree_effective');

        // Calcul des scores
        $scoreTaches = ($totalTaches > 0) ? ($tachesBienFaites / $totalTaches) * 100 : 0;
        $scoreTemps = ($totalTempsPrevus > 0 && $totalTempsEffectifs > 0) ? min(($totalTempsPrevus / $totalTempsEffectifs) * 100, 100) : 100;

        // Poids des critères
        $poidsTaches = 0.4;
        $poidsTemps = 0.3;
        $poidsQualite = 0.3;

        // Score de qualité basé sur la moyenne des notes
        $scoreQualite = $taches->avg('note') ?: 0;

        // Calcul de la note finale
        $noteFinale = ($scoreTaches * $poidsTaches) + ($scoreTemps * $poidsTemps) + ($scoreQualite * $poidsQualite);

        // Générer le PDF à partir de la vue 'evaluation.rapport'
        $pdf = FacadePdf::loadView('evaluation.rapport', [
            'stagiaire' => $stagiaire,
            'taches' => $taches,
            'note_finale' => round($noteFinale, 2),
            'total_taches' => $totalTaches,
            'taches_bien_faites' => $tachesBienFaites,
            'temps_total_prevu' => $totalTempsPrevus,
            'temps_total_effectif' => $totalTempsEffectifs
        ]);

        // Téléchargement du fichier PDF
        return $pdf->download('rapport_evaluation_stagiaire_'.$stagiaire->user->name.'.pdf');
    }
}
