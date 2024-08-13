<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_direction',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
