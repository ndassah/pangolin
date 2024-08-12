<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class loginController extends Controller
{
    public function login(Request $request) 
    {
        // Validation   
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // login
        $user = User::where('email',$request->email)->first();
        if($user || Hash::check($request->password,$user->password)){
            return $user;
        }else{
            return null;
        }

        if(!$user){
            return response([
                'message' => 'le compte n\'exist pas',
            ],401);
        }


        $token = $user->createToken('pangolin')->plainTextToken;
        // Retourner une réponse (par exemple, un token d'authentification)
        return response([
            'message' => 'Utilisateur enregistré avec succès',
            'user' => new UserResources($user),
            'token' => $token
        ], 202);
    }
}
