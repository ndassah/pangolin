<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_stagiaire',
        'nom',
        'niveau'
    ];

    //relation avec stagiaire
    public function stagiaire(){
        return $this->belongsTo(Stagiaire::class);
    }
}
