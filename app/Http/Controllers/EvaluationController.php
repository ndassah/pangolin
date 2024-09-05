<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function evaluerStagiaire($stagiaire_id)
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
        $totalTempsPrevus = $taches->sum('duree_prevue');
        $totalTempsEffectifs = $taches->sum('duree_effective');

        // Calcul des critères
        $scoreTaches = ($totalTaches > 0) ? ($tachesBienFaites / $totalTaches) * 100 : 0;
        $scoreTemps = ($totalTempsPrevus > 0) ? min(($totalTempsPrevus / $totalTempsEffectifs) * 100, 100) : 100;

        // Poids des critères
        $poidsTaches = 0.4; // 40% du score total
        $poidsTemps = 0.3;  // 30% du score total
        $poidsQualite = 0.3; // 30% du score total

        // Score de qualité basé sur les notes
        $scoreQualite = $taches->avg('note') ?: 0;

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
}
