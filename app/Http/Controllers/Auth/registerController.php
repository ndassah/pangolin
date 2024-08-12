<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class registerController extends Controller
{
    
    public function register(Request $request)
    {
        // Validation   
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone'=>'required|integer',
            'password' => 'required|string|min:8',
        ]);

        // Création   
        $user = User::create([
            'uuid'=> Str::uuid(),
            'nom' => $request->nom,
            'prenom'=>$request->prenom,
            'email' => $request->email,
            'telephone'=>$request->telephone,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('pangolin')->plainTextToken;
        // Retourner une réponse (par exemple, un token d'authentification)
        return response([
            'message' => 'Utilisateur enregistré avec succès',
            'user' => new UserResources($user),
            'token' => $token
        ], 200);
    }
}
