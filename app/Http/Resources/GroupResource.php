<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class GroupResource extends JsonResource
{
    
    public function __construct()
    {
       
    }
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
        ];
    }
}
