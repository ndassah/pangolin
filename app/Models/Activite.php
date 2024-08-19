<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_activites',
        'id_service',
        'description'
    ];


    public function taches()
    {
        return $this->hasMany(Tache::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
