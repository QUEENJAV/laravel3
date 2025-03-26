<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GroupResource;

class ContactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'numeroTelephone' => $this->numeroTelephone,
            'image' => $this->image,
            'groupe_id' => $this->groupe_id,
            'user_id' => $this->user_id,
            'is_favorite' => $this->is_favorite,
            'group' => $this->group,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,  
        ];
    }
}