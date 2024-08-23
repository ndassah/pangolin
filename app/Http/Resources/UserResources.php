<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->uuid,
            'role_id'=>$this->role_id,
            'nom'=>$this->nom,
            'prenom'=>$this->prenom,
            'email'=>$this->email,
            'email_verifiead_at'=>$this->email_verified_at,
            'telephone'=>$this->telephone,
            'password'=>$this->password,
            'created_at'=>$this->created_at,
            'update_at'=>$this->update_at,
        ];
    }
}
