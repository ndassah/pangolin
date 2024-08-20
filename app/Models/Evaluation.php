<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_stagiaire',
        'id_superviseur',
        'qualite_travail',
        'productivite',
        'aptitude',
        'engagement',
        'commmentaires',
        'note_global'
    ];
}
