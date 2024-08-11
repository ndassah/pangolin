<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class registerController extends Controller
{
    
    public function register(Request $request)
    {
       /* // Validation   
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

        ]);

        // Création   
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);*/

        // Retourner une réponse (par exemple, un token d'authentification)
        return response()->json([
            'message' => 'Utilisateur enregistré avec succès',
           // 'user' => $user
        ], 201);
    }
}
