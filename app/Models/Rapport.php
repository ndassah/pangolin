<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_tache',
        'contenu',
        'note',
        'stagiaire_id',
        'superviseur_id',
    ];

    //relation avec tache
    public function tache(){
        return $this->belongsTo(Tache::class);
    }
}
