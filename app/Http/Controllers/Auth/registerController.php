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
            'role_id'=>'required|exists:roles,id',
            'nom' => 'required|string|max:20',
            'prenom' => 'required|string|max:20',
            'email' => 'required|string|email|max:100|unique:users',
            'telephone'=>'required|integer',
            'password' => 'required|string|min:8',
            'service_id' => 'required_if:role_id,3|exists:services,id',
        ]);

        // Création   
        $user =$this->authservice->register($request);

        $token = $user->createToken('pangolin')->plainTextToken;
        
        return response([
            'message' => 'Utilisateur enregistré avec succès',
            'user' => new UserResources($user),
            'token' => $token
        ], 201);

    }

    //afficher un user par son id
    public function show($id){
        $user = User::Select(
            'nom',
            'prenom',
            'email',
            'telephone',
            'password',
            
        );
    }

    //afficher tout les user
    public function index(){
        $users = User::all();
        return $users;
    }
}
