<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superviseur extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'nom',
        'prenom',
        'email',
        'telephone',
        'password',
    ];
    public function stagiaire()
    {
        return $this->hasMany(Stagiaire::class);
    }
}
