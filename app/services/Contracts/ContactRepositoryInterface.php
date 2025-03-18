<?php

namespace App\Services\Contracts;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


interface ContactRepositoryInterface
{
    
    public function searchContacts(?string $query, int $userId): LengthAwarePaginator;
    public function createContact(array $data, int $userId): Contact;
    public function findById(int $id): ?Contact;
    public function updateContact(Contact $contact, array $data): Contact;
    public function deleteContact(Contact $contact): bool;
    public function updateContactFavoritesStatus(Contact $contact, bool $isFavorite): Contact;

    // public function delete(Contact $contact): bool;
    // public function updateFavoriteStatus(Contact $contact, bool $isFavorite): Contact;
    
    // public function findByUserWithFilters(int $userId, ?string $searchQuery, int $perPage): LengthAwarePaginator;
}
