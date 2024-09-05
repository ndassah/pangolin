<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notation extends Model
{
    use HasFactory;

    protected $fillable = [
        'stagiaire_id',
        'tache_id',
        'superviseur_id',
        'admin_id',
        'note',
        'commentaire',
    ];

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    public function tache()
    {
        return $this->belongsTo(Tache::class);
    }

    public function superviseur()
    {
        return $this->belongsTo(Superviseur::class);
    }

    public function admin()
    {
        return $this->belongsTo(Administrateur::class);
    }
}
