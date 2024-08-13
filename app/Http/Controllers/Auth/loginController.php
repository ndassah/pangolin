<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class loginController extends Controller
{

    protected AuthService $authservice;

    public function __construct(AuthService $authservice) {
        $this->authservice = $authservice;
    }

    public function login(Request $request) 
    {
        // Validation   
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // login
        $user =$this->authservice->login($request);

        if(!$user){
            return response([
                'message' => 'Utilisateur n\'existe pas',
            ], 401);
        }

        $token = $user->createToken('pangolin')->plainTextToken;
        // Retourner une réponse (par exemple, un token d'authentification)
       
    }
}
