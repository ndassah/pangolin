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
            'role_id'=> $request->role_id,
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

    public function otp(User $user, string  $type = 'verification'): Otp{

        //anti spam
        $essai = 3;
        $time = Carbon::now()->subMinutes(30);

        $count = Otp::where([
            'user_id' => $user->id,
            'type' => $type,
            'active' => 1
        ])->where('created_at','>=', $time)->count();

        if($count >= $essai){
            abort(422, 'Trop de tentatives, veuillez reessayer plustard ');
        }

        $code = random_int(100000,999999); //creation d'un code aleatoire
        $otp = Otp::create([
            'user_id' => $user->id,
            'type' =>$type,
            'code' => $code,
            'active' => 1
        ]);

         //envoi de l'email avec le code
         Mail::to($user)->send(new OtpMail($user, $otp));

        return $otp;
    }


    public function verify(User $user,object $request):User{
        $opt = Otp::where([
            'user_id' => $user->id,
            'code' => $request->otp,
            'active'=>1,
            'type'=>'verification',
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

    public function getUserByEmail(string $email):User{
        return User::where('email',$email)->first();
    }

    public function resetPassword(User $user, object $request):User{
        //validation de code otp
        $opt = Otp::where([
            'user_id' => $user->id,
            'code' => $request->otp,
            'active'=>1,
            'type'=>'password-reset',
        ])->first();

        if(!$opt){
            abort(422, 'le code otp n\'est pas correct');
         }

         $user->password = $request->password;
         $user->updated_at = Carbon::now();
         $user->update();

         $opt->active = 0;
         $opt->updated_at = Carbon::now();
         $opt->update();
        //nouveau password


        //return user
        return $user;
    }
}