<?php

namespace App\Http\Controllers;

use App\Models\Notation;
use Illuminate\Http\Request;

class notationController extends Controller
{
     // Liste des notations
     public function index()
     {
         $notations = Notation::with('stagiaire', 'tache', 'superviseur', 'administarteur')->get();
         return response()->json($notations);
     }
 
     // Créer une nouvelle notation
     public function store(Request $request)
     {
         $validated = $request->validate([
             'stagiaire_id' => 'required|exists:stagiaires,id',
             'tache_id' => 'required|exists:taches,id',
             'note' => 'required|integer|min:0|max:20',
             'commentaire' => 'nullable|string',
         ]);
 
         // Vérifiez si l'utilisateur est un superviseur ou un administrateur
         if (auth()->user()->role == 'superviseur') {
             $validated['superviseur_id'] = auth()->user()->superviseur->id;
         } elseif (auth()->user()->role == 'admin') {
             $validated['admin_id'] = auth()->user()->admin->id;
         } else {
             return response()->json(['error' => 'Unauthorized'], 403);
         }
 
         $notation = Notation::create($validated);
 
         return response()->json($notation->load('stagiaire', 'tache', 'superviseur', 'admin'), 201);
     }
 
     // Mettre à jour une notation
     public function update(Request $request, $id)
     {
         $notation = Notation::findOrFail($id);
 
         $validated = $request->validate([
             'note' => 'sometimes|integer|min:0|max:20',
             'commentaire' => 'nullable|string',
         ]);
 
         $notation->update($validated);
 
         return response()->json($notation->load('stagiaire', 'tache', 'superviseur', 'admin'));
     }
 
     // Afficher une notation spécifique
     public function show($id)
     {
         $notation = Notation::with('stagiaire', 'tache', 'superviseur', 'admin')->findOrFail($id);
         return response()->json($notation);
     }
 
     // Supprimer une notation
     public function destroy($id)
     {
         $notation = Notation::findOrFail($id);
         $notation->delete();
 
         return response()->json(null, 204);
     }
}
