<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_services',
        'id_direction'
    ];

    public function activites()
    {
        return $this->hasMany(Activite::class);
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }
    public function stagiaire()
    {
        return $this->hasMany(Stagiaire::class);
    }

}
