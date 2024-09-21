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
        'pourcentage',
        'validation_superviseur',
        'activite_id',
        'id_superviseur',
    ];

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }

    public function travaux()
    {
        return $this->hasMany(Travaux::class);
    }

    //relation avec rapport
    public function rapport(){
        return $this->hasOne(Rapport::class);
    }

    //relation avec superviseur
    public function superviseur(){
        return $this->belongsTo(Superviseur::class);
    }

    //relation avec evaluation
    public function evaluation(){
        return $this->hasMany(Evaluation::class);
    }

    

    
}
