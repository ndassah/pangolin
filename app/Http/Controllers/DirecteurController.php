<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DirecteurController extends Controller
{
    public function index()
    {
        // Récupérer les utilisateurs ayant le role_id correspondant à "directeur"
        $directeurs = User::whereHas('role', function ($query) {
            $query->where('name', 'directeur');
        })->get();

        return response()->json($directeurs);
    }

    // Mise à jour d'un directeur
    public function update(Request $request, $id)
    {
        $directeur = User::where('id', $id)->whereHas('role', function ($query) {
            $query->where('name', 'directeur');
        })->firstOrFail();

        $directeur->update($request->all());

        return response()->json([
            'message' => 'Directeur mis à jour avec succès',
            'data' => $directeur,
        ]);
    }

    public function show(string $id)
    {
        // Récupérer l'utilisateur par son ID avec les informations nécessaires
        $user = User::select('id', 'nom', 'prenom', 'email', 'telephone')
                    ->findOrFail($id); // Trouver l'utilisateur par son ID ou échouer
        
        // Retourner les informations de l'utilisateur sous forme de réponse JSON
        return response()->json([
            'user' => $user,
        ]);
    }
}
