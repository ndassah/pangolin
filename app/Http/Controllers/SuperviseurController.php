<?php

namespace App\Http\Controllers;

use App\Models\Superviseur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuperviseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les superviseurs avec leur nom depuis la relation avec la table users
        $superviseurs = Superviseur::with('user')->get();
    
        // Retourner uniquement l'id des superviseurs et le nom associé au user_id
        $formattedSuperviseurs = $superviseurs->map(function ($superviseur) {
            return [
                'id' => $superviseur->id,
                'nom_superviseur' => $superviseur->user->nom, // Nom du superviseur récupéré depuis la relation User
            ];
        });
    
        return response()->json($formattedSuperviseurs);
    }
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
        ]);

        $superviseur = Superviseur::create([
            'uuid'=> Str::uuid(),
            'user_id' => $validated['user_id'],
            'service_id' => $validated['service_id'],
        ]);

        return response()->json($superviseur->load('user', 'service'), 201);
    }

    /**
     * Display the specified resource.
     */
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

    


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $superviseur = Superviseur::findOrFail($id);

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $superviseur->update(array_filter([
            'service_id' => $validated['service_id'] ?? $superviseur->service_id,
        ]));

        return response()->json($superviseur->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $superviseur = Superviseur::findOrFail($id);
        $superviseur->delete();

        return response()->json(null, 204);
    }
}
