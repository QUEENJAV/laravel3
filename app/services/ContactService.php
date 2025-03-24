<?php  

namespace App\Services;

use App\Services\Contracts\ContactServiceInterface;
use App\Services\Contracts\ContactRepositoryInterface;
use App\Services\FileStorageServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use App\Services\ContactDTO;
use App\Services\ContactSearchDTO;
use Illuminate\Support\Facades\Storage;
use Exception;

class ContactService implements ContactServiceInterface
{
    private FileStorageServiceInterface $fileStorage;
    private ContactRepositoryInterface $contactRepository;

    public function __construct(FileStorageServiceInterface $fileStorage, ContactRepositoryInterface $contactRepository)
    {
        $this->fileStorage = $fileStorage;
        $this->contactRepository = $contactRepository;
    }

    public function searchContacts(ContactSearchDTO $dto): LengthAwarePaginator
    {
        return $this->contactRepository->searchContacts($dto->searchQuery, $dto->userId);
    }

    public function createContact(array $data, int $userId): Contact
    {
        $imagePath = null;

        if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            try {
                $imagePath = $this->fileStorage->storeFile($data['avatar'], 'upload');
            } catch (Exception $e) {
                throw new \RuntimeException('L\'avatar n\'a pas pu être téléchargé.');
            }
        } else {
            $imagePath = "no-image.jpg";
        }

        $contactDTO = ContactDTO::fromRequest([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'numeroTelephone' => $data['numeroTelephone'],
            'imagePath' => $imagePath,
            'groupeId' => $data['selectedGroup'] ?? null,
            'userId' => $userId,
            'is_favorite' => isset($data['is_favorite']) ? $data['is_favorite'] : false
        ]);

        $contactData = [
            'nom' => $contactDTO->nom,
            'prenom' => $contactDTO->prenom,
            'email' => $contactDTO->email,
            'numeroTelephone' => $contactDTO->numeroTelephone,
            'image' => $contactDTO->imagePath,
            'groupe_id' => $contactDTO->groupeId,
            'user_id' => $contactDTO->userId
        ];

        return $this->contactRepository->createContact($contactData, $userId);
    }

    public function findById(int $id): ?Contact
    {
        return $this->contactRepository->findById($id);
    }

    
    public function updateContact(Contact $contact, array $data): Contact
    {
        if (isset($data['avatar']) && $contact->image !== 'no-image.jpg') {
            Storage::disk('public')->delete($contact->image);
        }

        $contact->update([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'numeroTelephone' => $data['numeroTelephone'],
            'groupe_id' => $data['selectedGroup'] ?? $contact->groupe_id,
            'image' => isset($data['avatar']) ? $this->fileStorage->storeFile($data['avatar'], 'upload') : $contact->image
        ]);

        return $contact->fresh();
    }
    public function deleteContact(Contact $contact): bool
    {
        if ($contact->image !== 'no-image.jpg') {
            Storage::disk('public')->delete($contact->image);
        }

        return $contact->delete();
    }
    public function updateContactFavoritesStatus(Contact $contact, bool $isFavorite): Contact
    {
        $contact->is_favorite = $isFavorite ? 1 : 0;
        $contact->save();
        return $contact;
    }

    // private FileStorageServiceInterface $fileStorage;

    // public function __construct(FileStorageServiceInterface $fileStorage)
    // {
    //     $this->fileStorage = $fileStorage;
    // }

    // public function searchContacts(?string $query, int $userId): LengthAwarePaginator
    // {
    //     $contacts = Contact::where('user_id', $userId)
    //         ->with('group');
            
    //     if ($query && strlen($query) >= 2) {
    //         $contacts->where(function($q) use ($query) {
    //             $q->where('nom', 'LIKE', '%' . $query . '%')
    //               ->orWhere('prenom', 'LIKE', '%' . $query . '%')
    //               ->orWhere('email', 'LIKE', '%' . $query . '%');
    //         });
    //     }
        
    //     return $contacts->latest()->paginate(10);
    // }

    // public function createContact(array $data, int $userId): Contact
    // {
    //     $imagePath = null;
        
    //     if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
    //         $imagePath = $this->fileStorage->storeFile($data['avatar'], 'upload');
    //     } else {
    //         $imagePath = "no-image.jpg";
    //     }
        
    //     $contactDTO = ContactDTO::fromRequest($data, $imagePath, $userId);
        
    //     $contact = new Contact();
    //     $contact->nom = $contactDTO->nom;
    //     $contact->prenom = $contactDTO->prenom;
    //     $contact->email = $contactDTO->email;
    //     $contact->numeroTelephone = $contactDTO->numeroTelephone;
    //     $contact->image = $contactDTO->imagePath;
    //     $contact->groupe_id = $contactDTO->groupeId;
    //     $contact->user_id = $contactDTO->userId;
        
    //     $contact->save();
        
    //     return $contact;
    // }

    // public function findById(int $id): ?Contact
    // {
    //     return Contact::with('group')->find($id);
    // }
}

    // public function searchContacts(?string $searchQuery, int $userId): LengthAwarePaginator
    // {
    //     return Contact::query()
    //         ->where('user_id', $userId)
    //         ->when(
    //             $searchQuery && strlen($searchQuery) >= 2,
    //             fn (Builder $query) => $query->where('nom', 'LIKE', "%{$searchQuery}%")
    //         )
    //         ->with('group')
    //         ->latest()
    //         ->paginate(10);
    // }

//     public function createContact(array $data): Contact
// {
//     $contactData = [
//         'nom' => $data['nom'],
//         'prenom' => $data['prenom'],
//         'email' => $data['email'],
//         'numeroTelephone' => $data['telephone'], // Assurez-vous que le nom du champ correspond dans la base de données
//         'user_id' => $data['user_id'],
//         'groupe_id' => $data['selectedGroup'] ?? null,
//     ];

//     if (isset($data['avatar'])) {
//         $contactData['image'] = $this->storeImage($data['avatar']);
//     }

//     return Contact::create($contactData);
// }

// protected function storeImage(?UploadedFile $image): string
// {
//     if (!$image) {
//         return 'no-image.jpg';
//     }

//     try {
//         return $image->store('contacts', 'public');
//     } catch (\Exception $e) {
//         // \Log::error('Image upload failed: ' . $e->getMessage());
//         return 'no-image.jpg';
//     }
// }


//     // public function createContact(array $data): Contact
//     // {
//     //     return Contact::create([
//     //         'nom' => $data['nom'],
//     //         'prenom' => $data['prenom'],
//     //         'email' => $data['email'],
//     //         'numeroTelephone' => $data['telephone'],
//     //         'user_id' => $data['user_id'],
//     //         'groupe_id' => $data['selectedGroup'] ?? null,
//     //         'image' => $this->storeImage($data['avatar'] ?? null)
//     //     ]);
//     // }

//     public function updateContact(Contact $contact, array $data): Contact
//     {
//         if (isset($data['avatar']) && $contact->image !== 'no-image.jpg') {
//             Storage::disk('public')->delete($contact->image);
//         }

//         $contact->update([
//             'nom' => $data['nom'],
//             'prenom' => $data['prenom'],
//             'email' => $data['email'],
//             'numeroTelephone' => $data['telephone'],
//             'groupe_id' => $data['selectedGroup'] ?? $contact->groupe_id,
//             'image' => $this->storeImage($data['avatar'] ?? null) ?: $contact->image
//         ]);

//         return $contact->fresh();
//     }

//     public function deleteContact(Contact $contact): void
//     {
//         if ($contact->image !== 'no-image.jpg') {
//             Storage::disk('public')->delete($contact->image);
//         }
        
//         $contact->delete();
//     }

//     // protected function storeImage(?UploadedFile $image): string
//     // {
//     //     if (!$image) {
//     //         return 'no-image.jpg';
//     //     }

//     //     return $image->store('contacts', 'public');
//     // }
// }




// namespace App\Services;  

// use App\Models\Contact;  
// use Illuminate\Database\Eloquent\Builder;  
// use App\Services\ContactServiceInterface;  
// use App\Services\FileStorageServiceInterface; 
// use App\Services\ContactDTO;
// use App\Services\ContactSearchDTO;
// use App\Services\ContactUpdateDTO;

// class ContactService implements ContactServiceInterface  
// {  
//     /**  
//      * 
//      *  
//      * @param FileStorageServiceInterface $fileStorage  
//      */  
//     public function __construct(  
//         private readonly FileStorageServiceInterface $fileStorage  
//     ) {} 

//     /**  
//      * 
//      *  
//      * @param string|null $searchQuery  
//      * @param int $userId  
//      * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator  
//      */  

   

    // public function searchContacts(?string $searchQuery, int $userId)  
    // {  
    //     // Utiliser une requête Eloquent pour filtrer par utilisateur et recherche  
    //     return Contact::query()  
    //         ->where('user_id', $userId)  
    //         ->when(!empty($searchQuery), function (Builder $query) use ($searchQuery) {  
    //             $query->where('nom', 'LIKE', '%' . $searchQuery . '%');  
    //         })  
    //         ->with('group')  
    //         ->latest()  
    //         ->paginate(2);  
    // }  
   
    

    // public function findContactById($id)
    // {
    //     return Contact::find($id);
    // }

    // /**  
    //  * Create a new contact using the given ContactDTO and user ID.  
    //  *  
    //  * @param ContactDTO $contactDTO  
    //  * @param int $userId  
    //  * @return Contact  
    //  */  

    //  public function createContact(ContactDTO $contactDTO, int $userId): Contact
    // {
    //     $contact = new Contact();
    //     $contact->nom = $contactDTO->nom;
    //     $contact->prenom = $contactDTO->prenom;
    //     $contact->email = $contactDTO->email;
    //     $contact->numeroTelephone = $contactDTO->telephone;
    //     $contact->image = $contactDTO->imageUrl ?? 'no-image.jpg';
    //     $contact->user_id = $userId;
    //     $contact->groupe_id = $contactDTO->groupeId;
        
    //     $contact->save();
        
    //     return $contact;
    // }

    // public function createContact(ContactDTO $contactDTO, int $userId): Contact  
    // {  
    //     // Créer un nouveau contact avec les valeurs du DTO  
    //     return Contact::create([  
    //         'nom' => $contactDTO->nom,  
    //         'prenom' => $contactDTO->prenom,  
    //         'email' => $contactDTO->email,  
    //         'numeroTelephone' => $contactDTO->numeroTelephone,  
    //         'image' => $contactDTO->imageUrl ?? 'no-image.jpg',  
    //         'user_id' => $userId,  
    //         'groupe_id' => $contactDTO->groupeId,  
    //     ]);  
    // }  

    // public function updateContact(int $id, ContactUpdateDTO $dto)
    // {
    //     $contact = $this->findContactById($id);

    //     if (!$contact) {
    //         throw new \Exception("Contact non trouvé");
    //     }

    //     $contact->update([
    //         'nom' => $dto->nom,
    //         'email' => $dto->email,
    //     ]);

    //     return $contact;
    // }

    // public function createContact(array $data)
    // {
    //     $contact = new Contact();
    //     $contact->nom = $data['nom'];
    //     $contact->prenom = $data['prenom'];
    //     $contact->email = $data['email'];
    //     $contact->numeroTelephone = $data['telephone'];
    //     $contact->user_id = $data['user_id'];
    //     $contact->groupe_id = $data['selectedGroup'];

    //     if (isset($data['avatar'])) {
    //         $contact->image = $this->storeImage($data['avatar']);
    //     } else {
    //         $contact->image = "no-image.jpg";
    //     }

    //     $contact->save();
    //     return $contact;
    // }

    // public function storeImage($image)
    // {
    //     return $image->store('upload', 'public');
    // }


    // public function createContact(array $data, $user)
    // {
    //     $contact = new Contact();
    //     $contact->nom = $data['nom'];
    //     $contact->prenom = $data['prenom'];
    //     $contact->email = $data['email'];
    //     $contact->numeroTelephone = $data['telephone'];
    //     $contact->user_id = $user->id;
    //     $contact->groupe_id = $data['selectedGroup'];
        
    //     // Handle image upload
    //     if (isset($data['avatar'])) {
    //         $contact->image = $this->uploadImage($data['avatar']);
    //     } else {
    //         $contact->image = "no-image.jpg"; // Default image
    //     }

    //     $contact->save();
    //     return $contact;
    // }

    // protected function uploadImage($image)
    // {
    //     try {
    //         $imagePath = $image->store('upload', 'public');
    //         return "http://localhost:8000/storage/$imagePath";
    //     } catch (\Exception $e) {
    //         throw new \Exception('Image upload failed: ' . $e->getMessage());
    //     }
    // }


    // public function createContact(array $data, $userId): Contact
    // {
    //     dd($data);
    //     $contactData = [
    //         'nom' => $data['nom'],
    //         'prenom' => $data['prenom'],
    //         'email' => $data['email'],
    //         'numeroTelephone' => $data['numeroTelephone'],
    //         'user_id' => $userId['user_id'],
    //         'groupe_id' => $data['selectedGroup'] ?? null,
    //         'image' => 'no-image.jpg'
    //     ];
    //     if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
    //         dd("la fille de Yemelong");
    //         try {
    //             $contactData['image'] = $this->storeImage($data['avatar']);
    //             dd($contactData);
    //         } catch (\Exception $e) {
    //             dd($e);
    //             //\Log::error('Image upload failed: ' . $e->getMessage());
    //         }
    //     }
    //     return Contact::create($contactData);
    // }
    // protected function storeImage(UploadedFile $image): string
    // {
    //     try {
            
    //         $path = $image->store('contacts', 'public');
    //         if (!$path) {
    //             throw new \Exception('Failed to store image');
    //         }
    //         return $path;
    //     } catch (\Exception $e) {
    //         //\Log::error('Image storage failed: ' . $e->getMessage());
    //         throw $e; 
    //     }
    // }

    // public function updateContact(Contact $contact, array $data)
    // {
    //     $contact->nom = $data['nom'];
    //     $contact->prenom = $data['prenom'];
    //     $contact->email = $data['email'];
    //     $contact->numeroTelephone = $data['telephone'];
        
    //     if (isset($data['selectedGroup'])) {
    //         $contact->groupe_id = $data['selectedGroup'];
    //     }

    //     if (isset($data['avatar'])) {
    //         $contact->image = $this->storeImage($data['avatar']);
    //     }

    //     $contact->save();
    //     return $contact;
    // }   

//     public function deleteContact(Contact $contact)
//     {
//         $contact->delete();
//     }

//     public function toggleFavorite(Contact $contact, $status)
//     {
//         $contact->favorite = $status;
//         $contact->save();
//         return $contact;
//     }
// }
