<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'tache_id',
        'superviseur_id',
        'note',
        'feedback',
    ];

    public function tache()
    {
        return $this->belongsTo(Tache::class);
    }

    public function superviseur()
    {
        return $this->belongsTo(Superviseur::class);
    }
}
