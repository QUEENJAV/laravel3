<?php

namespace App\Services\Contracts;

use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\ContactDTO;
use Illuminate\Http\UploadedFile;
use App\Services\ContactSearchDTO;
interface ContactServiceInterface

{
    public function searchContacts(ContactSearchDTO $dto): LengthAwarePaginator;
    // public function searchContacts(?string $query, int $userId): LengthAwarePaginator;
    public function createContact(array $data, int $userId): Contact;
    public function findById(int $id): ?Contact;
    public function updateContact(Contact $contact, array $data): Contact;
    public function deleteContact(Contact $contact): bool;
    public function updateContactFavoritesStatus(Contact $contact, bool $isFavorite): Contact;
    //public function getContactsList(int $userId, ?string $searchQuery, int $perPage): LengthAwarePaginator;

//     // public function searchContacts($searchQuery,$userId);
    
//     public function searchContacts(?string $searchQuery, int $userId)  ;
//     public function findContactById($id);
//     public function createContact(ContactDTO $contactDTO, int $userId): Contact;
//     public function updateContact(int $id, array $data);
//     // public function createContact(array $data, $userId): Contact;
//     // public function createContact(array $data,$userId);
//     // public function updateContact(Contact $contact, array $data);
//     public function deleteContact(Contact $contact);
//     public function toggleFavorite(Contact $contact, $status);

   
//     // public function storeFile($file, string $path): string;

    
}
