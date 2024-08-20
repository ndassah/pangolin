<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superviseur extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'user_id',
        'nom',
        'prenom',
        'email',
        'telephone',
        'password',
    ];

    //relation avec stagiaire
    public function stagiaire()
    {
        return $this->hasMany(Stagiaire::class);
    }

    //relation avec service
    public function service(){
        return $this->belongsTo(Service::class);
    }

    //relation avec user
    public function user(){
        return $this->belongsTo(User::class);
    }
}
