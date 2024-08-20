<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_services',
        'id_direction',
        'description',
    ];

    //relation avec activitee
    public function activites()
    {
        return $this->hasMany(Activite::class);
    }


    //relation avec direction
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    //relation avec stagiaire
    public function stagiaire()
    {
        return $this->hasMany(Stagiaire::class);
    }

    //relation avec superviseur
    public function superviseur(){
        return $this->hasMany(Superviseur::class);
    }

}
