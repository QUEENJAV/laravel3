<?php  

namespace App\Services;

use App\Services\Contracts\ContactServiceInterface;
use App\Services\Contracts\ContactRepositoryInterface;
use App\Services\Contracts\FileStorageServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use App\Services\DTO\ContactDTO;
use App\Services\DTO\ContactSearchDTO;
use Illuminate\Support\Facades\Storage;
use Exception;

class ContactService implements ContactServiceInterface
{
    private FileStorageServiceInterface $fileStorageServiceInterface;
    private ContactRepositoryInterface $contactRepositoryInterface;

    public function __construct(
        FileStorageServiceInterface $fileStorageServiceInterface, 
        ContactRepositoryInterface $contactRepositoryInterface
    ){
        $this->fileStorageServiceInterface = $fileStorageServiceInterface;
        $this->contactRepositoryInterface = $contactRepositoryInterface;
    }

    public function searchContacts(ContactSearchDTO $dto): LengthAwarePaginator
    {
        return $this->contactRepositoryInterface->searchContacts($dto->searchQuery, $dto->userId);
    }

    public function createContact(array $data, int $userId): Contact
    {
        $imagePath = null;

        if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            try {
                $imagePath = $this->fileStorageServiceInterface->storeFile($data['avatar'], 'upload');
            } catch (Exception $e) {
                throw new \RuntimeException('L\'avatar n\'a pas pu être téléchargé.');
            }
        } 
        else {
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

        return $this->contactRepositoryInterface->createContact($contactData, $userId);
    }

    public function findById(int $id): ?Contact
    {
        return $this->contactRepositoryInterface->findById($id);
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
            'image' => isset($data['avatar']) ? $this->fileStorageServiceInterface->storeFile($data['avatar'], 'upload') : $contact->image
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
}