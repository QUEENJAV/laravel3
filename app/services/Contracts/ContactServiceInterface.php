<?php

namespace App\Services\Contracts;

use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\DTO\ContactDTO;
use Illuminate\Http\UploadedFile;
use App\Services\DTO\ContactSearchDTO;

interface ContactServiceInterface
{
    public function searchContacts(ContactSearchDTO $dto): LengthAwarePaginator;
    public function createContact(array $data, int $userId): Contact;
    public function findById(int $id): ?Contact;
    public function updateContact(Contact $contact, array $data): Contact;
    public function deleteContact(Contact $contact): bool;
    public function updateContactFavoritesStatus(Contact $contact, bool $isFavorite): Contact;   
}
