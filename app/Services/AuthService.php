<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        //envoi d'un code de verification
        $this->otp($user);
        return $user;
    }

    public function login(object $request) : ? User{
        $user = User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
            return $user;
        }
        return null;
    }

    public function otp(User $user): Otp{
        $code = random_int(100000,999999); //creation d'un code aleatoire
        $otp = Otp::create([
            'user_id' => $user->id,
            'type' => 'verification',
            'code' => $code,
            'active' => 1
        ]);

         //envoi de l'email avec le code
         Mail::to($user)->send(new OtpMail($user, $code));

        return $otp;
    }


    public function verify(User $user,object $request):User{
        $opt = Otp::where([
            'user_id' => $user->id,
            'code' => $request->otp,
            'active'=>1
        ])->first();

        if(!$opt){
           abort(422, 'Invalid verification code');
        }

        //update user
        $user->email_verified_at = Carbon::now();
        $user->update();

        $opt->active = 0;
        $opt->updated_at = Carbon::now();
        $opt->update();

        return $user;
    }
}