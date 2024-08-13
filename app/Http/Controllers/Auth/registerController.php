<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class registerController extends Controller
{

    protected AuthService $authservice;

    public function __construct(AuthService $authservice) {
        $this->authservice = $authservice;
    }
    
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
        $user =$this->authservice->register($request);

        $token = $user->createToken('pangolin')->plainTextToken;
        // Retourner une réponse (par exemple, un token d'authentification)
        return response([
            'message' => 'Utilisateur enregistré avec succès',
            'user' => new UserResources($user),
            'token' => $token
        ], 201);
    }
}
