<?php

namespace App\Services\DTO;

class ContactSearchDTO
{
    public ?string $searchQuery;
    public int $userId;
    public function __construct(?string $searchQuery, int $userId)
    {
        $this->searchQuery = $searchQuery;
        $this->userId = $userId;
    }
    
}
