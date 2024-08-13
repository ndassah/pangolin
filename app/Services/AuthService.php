<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService{
    public function register(object $request) : User{
        $user = User::create([
            'uuid'=> Str::uuid(),
            'nom' => $request->nom,
            'prenom'=>$request->prenom,
            'email' => $request->email,
            'telephone'=>$request->telephone,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }

    public function login(object $request) : ? User{
        $user = User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
            return $user;
        }
        return null;
    }
}