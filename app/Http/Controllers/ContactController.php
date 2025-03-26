<?php 
namespace App\Http\Controllers;  

use Illuminate\Http\Request;  
use App\Models\Contact;  
use App\Http\Requests\ContactIndexRequest;
use App\Http\Resources\ContactResource;
use App\Services\Contracts\ContactServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\StoreContactRequest;   
use App\Http\Requests\UpdateContactRequest; 
use Illuminate\Http\JsonResponse;
use App\Services\DTO\ContactDTO;
use App\Services\DTO\ContactSearchDTO;
use Exception;

class ContactController extends Controller  
{ 
    private ContactServiceInterface $contactServiceInterface;

    public function __construct(ContactServiceInterface $contactServiceInterface)
    {
        $this->contactServiceInterface = $contactServiceInterface;
    }
    public function index(Request $request)
    {
        $dto = new ContactSearchDTO($request->get('searchQuery'), $request->user()->id);
        return $this->contactServiceInterface->searchContacts($dto);
       
    }

    public function store(StoreContactRequest $request): JsonResponse
    {
        try {
            $contact = $this->contactServiceInterface->createContact(
                $request->validated(),
                $request->user()->id
            );
            
            return response()->json([
                'data' => new ContactResource($contact),
                'success' => 'Contact created successfully'
            ]);
        } 
        catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to create contact: ' . $e->getMessage()
            ], 422);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $contact = $this->contactServiceInterface->findById($id);
            
            if (!$contact) {
                return response()->json(['message' => 'Contact non trouvé'], 404);
            }
            
            return response()->json(new ContactResource($contact));
        } 
        catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve contact: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateContactRequest $request, int $id): JsonResponse
    {
        try {
            $contact = $this->contactServiceInterface->findById($id);
            $updatedContact = $this->contactServiceInterface->updateContact($contact, $request->validated());
            
            return response()->json([
                'data' => new ContactResource($updatedContact),
                'success' => 'Contact updated successfully'
            ]);
        } 
        catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update contact: ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $contact = $this->contactServiceInterface->findById($id);
            if (!$contact) {
                return response()->json(['error' => 'Contact not found'], 404);
            }
            $this->contactServiceInterface->deleteContact($contact);

            return response()->json(['success' => 'Contact deleted successfully']);
        } 
        catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete contact: ' . $e->getMessage()], 500);
        }
    }

    public function updateFavoriteStatus(int $id, Request $request): JsonResponse
    {
        $isFavorite = $request->input('is_favorite');
        try {
            $contact = $this->contactServiceInterface->updateContactFavoritesStatus($this->contactServiceInterface->findById($id), $isFavorite);
            
            return response()->json([
                'data' => new ContactResource($contact),
                'success' => 'Contact favorite status updated successfully'
            ]);
        } 
        catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update contact favorite status: ' . $e->getMessage()
            ], 422);
        }
    }

    public function liste(Request $request): JsonResponse
    {
        try {
            $contacts = Contact::query()
                ->when($request->get('searchQuery'), function ($query, $searchQuery) {
                    $query->where('nom', 'like', '%' . $searchQuery . '%')
                          ->orWhere('prenom', 'like', '%' . $searchQuery . '%')
                          ->orWhere('email', 'like', '%' . $searchQuery . '%');
                })
                ->latest()
                ->paginate(10);

            return response()->json([
                'data' => ContactResource::collection($contacts),
                'links' => [
                    'first' => $contacts->url(1),
                    'last' => $contacts->url($contacts->lastPage()),
                    'prev' => $contacts->previousPageUrl(),
                    'next' => $contacts->nextPageUrl(),
                ],
                'meta' => [
                    'current_page' => $contacts->currentPage(),
                    'from' => $contacts->firstItem(),
                    'last_page' => $contacts->lastPage(),
                    'path' => $contacts->path(),
                    'per_page' => $contacts->perPage(),
                    'to' => $contacts->lastItem(),
                    'total' => $contacts->total(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve contacts: ' . $e->getMessage()], 500);
        }
    }
}

