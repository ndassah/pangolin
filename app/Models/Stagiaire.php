<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Stagiaire extends Model
{
    use HasFactory, HasApiTokens, Notifiable;


    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'password',
    ];
    public function tache()
    {
        return $this->hasMany(Tache::class);
    }
    public function superviseur()
    {
        return $this->belongsTo(Superviseur::class);
    }
}
