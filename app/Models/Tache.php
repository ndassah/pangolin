<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'date_debut',
        'date_fin',
        'status',
        'statgiaire_id',
        'id_activies',
    ];

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }
}
