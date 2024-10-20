<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHasRoles extends Model
{
    // Spécifier le nom de la table
    protected $table = 'model_has_roles';

    // Définir les champs pouvant être remplis via des méthodes de type "create"
    protected $fillable = ['role_id', 'model_type', 'model_id'];

    // Désactiver les timestamps si la table ne les utilise pas
    public $timestamps = false;

    /**
     * Relation avec le modèle Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relation avec le modèle User ou tout autre modèle
     */
    public function model()
    {
        return $this->morphTo();
    }
}
