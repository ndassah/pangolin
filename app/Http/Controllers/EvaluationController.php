<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use App\Models\Travaux;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function evaluerStagiaire($stagiaire_id)
    {
        $stagiaire = Stagiaire::find($stagiaire_id);

        if (!$stagiaire) {
            return response()->json(['message' => 'Stagiaire introuvable'], 404);
        }

        // Récupération des travaux associés au stagiaire
        $travaux = Travaux::where('stagiaire_id', $stagiaire_id)->get();

        if ($travaux->isEmpty()) {
            return response()->json([
                'message' => 'Aucun travail associé à ce stagiaire.',
                'total_travaux' => 0,
                'travaux_bien_faits' => 0,
                'temps_total_prevu' => 0,
                'temps_total_effectif' => 0,
                'note_finale' => 0
            ], 200);
        }

        $totalTravaux = $travaux->count();
        $travauxBienFaits = $travaux->where('note', '>=', 50)
                                     ->where('status', 'terminé')
                                     ->count();

        $totalTempsPrevus = $travaux->sum('duree_prevue');
        $totalTempsEffectifs = $travaux->sum('duree_effective');

        $scoreTravaux = ($totalTravaux > 0) ? ($travauxBienFaits / $totalTravaux) * 100 : 0;
        $scoreTemps = ($totalTempsPrevus > 0 && $totalTempsEffectifs > 0) ? min(($totalTempsPrevus / $totalTempsEffectifs) * 100, 100) : 100;

        $poidsTravaux = 0.4;
        $poidsTemps = 0.3;
        $poidsQualite = 0.3;

        $scoreQualite = is_numeric($travaux->avg('note')) ? $travaux->avg('note') : 0;
        $noteFinale = ($scoreTravaux * $poidsTravaux) + ($scoreTemps * $poidsTemps) + ($scoreQualite * $poidsQualite);

        return response()->json([
            'total_travaux' => $totalTravaux,
            'travaux_bien_faits' => $travauxBienFaits,
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

        $travaux = Travaux::where('stagiaire_id', $stagiaire_id)->get();

        $totalTravaux = $travaux->count();
        $travauxBienFaits = $travaux->where('note', '>=', 70)
                                     ->where('status', 'terminé')
                                     ->count();

        $totalTempsPrevus = $travaux->sum('duree_prevue');
        $totalTempsEffectifs = $travaux->sum('duree_effective');

        $scoreTravaux = ($totalTravaux > 0) ? ($travauxBienFaits / $totalTravaux) * 100 : 0;
        $scoreTemps = ($totalTempsPrevus > 0 && $totalTempsEffectifs > 0) ? min(($totalTempsPrevus / $totalTempsEffectifs) * 100, 100) : 100;

        $poidsTravaux = 0.4;
        $poidsTemps = 0.3;
        $poidsQualite = 0.3;

        $scoreQualite = $travaux->avg('note') ?: 0;
        $noteFinale = ($scoreTravaux * $poidsTravaux) + ($scoreTemps * $poidsTemps) + ($scoreQualite * $poidsQualite);

        $pdf = FacadePdf::loadView('evaluation.rapport', [
            'stagiaire' => $stagiaire,
            'travaux' => $travaux,
            'note_finale' => round($noteFinale, 2),
            'total_travaux' => $totalTravaux,
            'travaux_bien_faits' => $travauxBienFaits,
            'temps_total_prevu' => $totalTempsPrevus,
            'temps_total_effectif' => $totalTempsEffectifs
        ]);

        return $pdf->download('rapport_evaluation_stagiaire_'.$stagiaire->user->name.'.pdf');
    }
}
