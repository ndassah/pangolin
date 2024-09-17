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
    // Validation des champs
    $request->validate([
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8',
    ]);

    // Tentative de login
    $user = $this->authservice->login($request);

    if (!$user) {
        return response([
            'message' => 'Utilisateur n\'existe pas',
        ], 401);
    }

    // Création de session Laravel pour cet utilisateur
    auth()->login($user); 

    // Génération du token et récupération du role_id
    $token = $user->createToken('pangolin')->plainTextToken;
    return response([
        'message' => 'Utilisateur authentifié',
        'results' => [
            'user' => new UserResources($user),
            'token' => $token,
            'role_id' => $user->role_id, // Envoi du role_id dans la réponse
        ]
    ], 201);

        $userId = session('user_id');
        $userEmail = session('user_email');
        $authToken = session('auth_token');
    }

    public function logout(Request $request)
    {
        // Récupérer l'utilisateur connecté
        $user = $request->user();
    
        // Supprimer tous les tokens de l'utilisateur pour le déconnecter
        $user->tokens()->delete();
    
        return response()->json([
            'message' => 'Déconnexion réussie',
        ]);
    }
    
    //Otp
    public function otp(Request $request) 
    {
        $request->validate([
            'token' => 'required|string',
        ]);
        
        // get the user from token
        $user = $this->authservice->getUserFromToken($request->token);
    
        // generate the otp
        $otp = $this->authservice->otp($user);
    
        return response([
            'message' => 'Verification réussie',
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

    public function resetOtp(Request $request) 
    {
    
        // validate the request
        $request->validate([
            'email'=>'required|email|exists:users,email',
        ]);
        // get the user
        $user= $this->authservice->getUserByEmail($request->email);

        //generer le otp
        $otp = $this->authservice->otp($user, 'password-reset');

        return response([
            'message' => 'code reinitialisation envoye ',
        ], 201);
       
    }

    public function resetPassword(Request $request) 
    {
    
        // validate the request
        $request->validate([
            'email'=>'required|email|exists:users,email',
            'otp'=>'required|numeric',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);
        // get the user
        $user= $this->authservice->getUserByEmail($request->email);

        //generer le otp
        $user = $this->authservice->resetPassword($user, $request);

        return response([
            'message' => 'mot de pass reinitilise ',
        ], 201);
       
    }
    
}
