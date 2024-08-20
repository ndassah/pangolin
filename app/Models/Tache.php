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
        'date_fin',
        'status',
        'statgiaire_id',
        'id_activies',
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
}
