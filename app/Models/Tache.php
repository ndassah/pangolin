<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'duree prevue',
        'duree effective',
        'status',
        'feedback',
        'note',
        'validation_superviseur',
        'stagiaire_id',
        'id_activites',
        'id_superviseur',
    ];

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }
    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    //relation avec rapport
    public function rapport(){
        return $this->hasOne(Rapport::class);
    }

    //relation avec superviseur
    public function superviseur(){
        return $this->belongsTo(Superviseur::class);
    }
}
