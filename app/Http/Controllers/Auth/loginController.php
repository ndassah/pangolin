<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class loginController extends Controller
{

    protected AuthService $authservice;

    public function __construct(AuthService $authservice) {
        $this->authservice = $authservice;
    }
    
    //Login
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

        return response([
            'message' => 'Utilisateur retouvée ',
            'results' =>[
                'user' => new UserResources($user),
                'token' => $token
            ]
        ], 201);
       
    }

    //Otp
    public function otp(Request $request) 
    {
    
        // get the user
        $user =auth()->user();

        //generer le otp
        $otp = $this->authservice->otp($user);

        return response([
            'message' => 'verification reussi ',
        ], 201);
       
    }

    //verification du code otp
    public function verify(Request $request) :Response
    {
        $request->validate([
            'otp'=> 'required|numeric',
        ]);
    
        // get the user
        $user =auth()->user();

        //verifier le otp code
        $user = $this->authservice->verify($user,$request);

        return response([
            'message' => 'verification du opt reussi ',
            'result'=>[
                 'user' => new UserResources($user)
            ]
        ], 201);
       
    }
}
