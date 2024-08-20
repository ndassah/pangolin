<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
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

    //relation avec le user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
