<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travaux extends Model
{
    use HasFactory;

    protected $table = 'travaux';
    
    protected $fillable = [
        'nom',
        'tache_id',
        'status', // Peut être 'terminé' ou 'non terminé'
        'description',
        'stagiaire_id',
    ];

    public function tache()
    {
        return $this->belongsTo(Tache::class);
    }

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
}
