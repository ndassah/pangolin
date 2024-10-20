<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Stagiaire extends Model
{
    use HasFactory, HasApiTokens, Notifiable;


    protected $fillable = [
        'uuid',
        'user_id',
        'service_id',
    ];


    //relation avec le user
    public function user(){
        return $this->belongsTo(User::class);
    }

    //relation avec les tache
    public function taches()
    {
        return $this->hasMany(Tache::class);
    }

    //relation avec le superviseur
    public function superviseur()
    {
        return $this->hasOne(Superviseur::class);
    }

    //relation avec le service
    public function Service()
    {
        return $this->belongsTo(Service::class);
    }
    


    //relation avec le profil
    // public function profil(){
    //     return $this->belongsTo(Profil::class);
    // }

    //relation avec le rapport
    public function rapport(){
        return $this->hasMany(Rapport::class);
    }

    //relation avec la notation
    public function notation(){
        return $this->hasMany(Notation::class);
    }

    //relation avec les competence
    public function competence(){
        return $this->hasMany(Competence::class);
    }
}
