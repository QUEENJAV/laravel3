<?php

namespace App\Repositories;

use App\Services\Contracts\ContactRepositoryInterface;
use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactRepository implements ContactRepositoryInterface
{
    public function searchContacts(?string $query, int $userId): LengthAwarePaginator
    {
        $contacts = Contact::where('user_id', $userId)
            ->with('group');
 
        if ($query && strlen($query) >= 2) {
            $contacts->where(function($q) use ($query) {
                $q->where('nom', 'LIKE', '%' . $query . '%')
                  ->orWhere('prenom', 'LIKE', '%' . $query . '%')
                  ->orWhere('email', 'LIKE', '%' . $query . '%');
            });
        }

        return $contacts->latest()->paginate(5); 
    }
    
    public function findById(int $id): ?Contact
    {
        return Contact::with('group')->find($id);
    }

    public function createContact(array $data, int $userId): Contact
    {
        $contact = new Contact();
        $contact->nom = $data['nom'];
        $contact->prenom = $data['prenom'];
        $contact->email = $data['email'];
        $contact->numeroTelephone = $data['numeroTelephone'];
        $contact->image = $data['image'] ?? 'no-image.jpg';
        $contact->groupe_id = $data['groupe_id'] ?? null;
        $contact->user_id = $userId;

        $contact->save();
        return $contact;
    }
    public function updateContact(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact;
    }

    public function deleteContact(Contact $contact): bool
    {
        return $contact->delete();
    }

    public function updateContactFavoritesStatus(Contact $contact, bool $isFavorite): Contact
    {
        $contact->favorite = $isFavorite;
        $contact->save();
        return $contact;
    }


}