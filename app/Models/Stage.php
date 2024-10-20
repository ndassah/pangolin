<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_service',
        'date_debut',
        'date_fin',
    ];


    //relation avec service
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
