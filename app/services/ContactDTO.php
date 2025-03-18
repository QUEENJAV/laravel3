<?php

namespace App\Services;
use App\Http\Requests\StoreContactRequest; 

class ContactDTO
{
   

    /**
     * Create a new class instance.
     */
    public string $nom;
    public string $prenom;
    public string $email;
    public string $numeroTelephone;
    public ?string $imagePath;
    public ?int $groupeId;
    public int $userId;
    public int $is_favorite;

    public static function fromRequest(array $data): self
    {
        $dto = new self();
        $dto->nom = $data['nom'];
        $dto->prenom = $data['prenom'];
        $dto->email = $data['email'];
        $dto->numeroTelephone = $data['numeroTelephone'];
        $dto->imagePath = $data['imagePath'];
        $dto->groupeId = $data['groupeId'];
        $dto->userId = $data['userId'];
        $dto->is_favorite = $data['s_favorite'];
        return $dto;
    }
}
