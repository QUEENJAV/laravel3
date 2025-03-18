<?php 
namespace App\Http\Controllers;  


use Illuminate\Http\Request;  
use App\Models\Contact;  
use App\Http\Requests\ContactIndexRequest;
use App\Http\Resources\ContactResource;
use App\Services\Contracts\ContactServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\StoreContactRequest;   
// use App\Http\Requests\UpdateContactRequest; 
use App\Http\Requests\UpdateContactRequest; 
use Illuminate\Http\JsonResponse;
use App\Services\ContactDTO;
use App\Services\ContactSearchDTO;

use Exception;

class ContactController extends Controller  
{ 
    private ContactServiceInterface $contactService;

    public function __construct(ContactServiceInterface $contactService)
    {
        $this->contactService = $contactService;
    }
    
    public function index(Request $request)
    {
        $dto = new ContactSearchDTO($request->get('searchQuery'), $request->user()->id);
        return $this->contactService->searchContacts($dto);

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
        ], 200);
        // $dto = new ContactSearchDTO($request->get('searchQuery'), $request->user()->id);
        // $contacts = $this->contactService->searchContacts($dto);
        
        // return response()->json(ContactResource::collection($contacts)->response()->getData(true), 200);
    }
    
    public function store(StoreContactRequest $request): JsonResponse
    {
        try {
            $contact = $this->contactService->createContact(
                $request->validated(),
                $request->user()->id
            );
            
            return response()->json([
                'data' => new ContactResource($contact),
                'success' => 'Contact created successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to create contact: ' . $e->getMessage()
            ], 422);
        }
    }
    
    public function show(int $id): JsonResponse
    {
        try {
            $contact = $this->contactService->findById($id);
            
            if (!$contact) {
                return response()->json(['message' => 'Contact non trouvé'], 404);
            }
            
            return response()->json(new ContactResource($contact));
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve contact: ' . $e->getMessage()
            ], 500);
        }
    }
    public function update(UpdateContactRequest $request, int $id): JsonResponse
    {
        try {
            $contact = $this->contactService->findById($id);
            $updatedContact = $this->contactService->updateContact($contact, $request->validated());
            
            return response()->json([
                'data' => new ContactResource($updatedContact),
                'success' => 'Contact updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update contact: ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $contact = $this->contactService->findById($id);
            $this->contactService->deleteContact($contact);
            
            return response()->json([
                'success' => 'Contact deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to delete contact: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateFavoriteStatus(int $id, Request $request): JsonResponse
    {
        $isFavorite = $request->input('is_favorite');
        try {
            $contact = $this->contactService->updateContactFavoritesStatus($this->contactService->findById($id), $isFavorite);
            
            return response()->json([
                'data' => new ContactResource($contact),
                'success' => 'Contact favorite status updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update contact favorite status: ' . $e->getMessage()
            ], 422);
        }
    }

 
    // public function update(UpdateContactRequest $request, int $id): JsonResponse
    // {
    //     try {
    //         $contact = $this->contactService->updateContact($id, $request->validated());
            
    //         return response()->json([
    //             'data' => new ContactResource($contact),
    //             'success' => 'Contact updated successfully'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'error' => 'Failed to update contact: ' . $e->getMessage()
    //         ], 422);
    //     }
    // }

    // public function destroy(int $id): JsonResponse
    // {
    //     try {
    //         $this->contactService->deleteContact($id);
            
    //         return response()->json([
    //             'success' => 'Contact deleted successfully'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'error' => 'Failed to delete contact: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    }

    // public function update(UpdateContactRequest $request, int $id): JsonResponse
    // {
    //     try {
    //         $contact = $this->contactService->updateContact($id, $request->validated());
            
    //         return response()->json([
    //             'data' => new ContactResource($contact),
    //             'success' => 'Contact updated successfully'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'error' => 'Failed to update contact: ' . $e->getMessage()
    //         ], 422);
    //     }
    // }

    // public function destroy(int $id): JsonResponse
    // {
    //     try {
    //         $this->contactService->deleteContact($id);
            
    //         return response()->json([
    //             'success' => 'Contact deleted successfully'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'error' => 'Failed to delete contact: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // protected $ContactServiceInterface;  

    
    // public function __construct(
    //     private readonly ContactServiceInterface $contactService,
    //     private readonly FileStorageServiceInterface $fileStorage
    // ) {}
    
    // public function index(Request $request)
    // {
    //     $dto = new ContactSearchDTO($request->searchQuery, $request->user()->id);
    //     $contacts = $this->contactService->searchContacts($dto->searchQuery, $dto->userId);
    //     return response()->json($contacts, 200);
    // }

    // public function show($id)
    // {
    //     $contact = $this->contactService->findContactById($id);
        
    //     if (!$contact) {
    //         return response()->json(['message' => 'Contact non trouvé'], 404);
    //     }
        
    //     return response()->json($contact);
    // }
     
    // public function store(ContactStoreRequest $request): JsonResponse
    // {
    //     try {
    //         $imageUrl = null;
    //         if ($request->hasFile('avatar')) {
    //             $imageUrl = $this->fileStorage->storeFile(
    //                 $request->file('avatar'),
    //                 'upload'
    //             );
    //         }

    //         $contactDTO = ContactDTO::fromRequest($request, $imageUrl);
            
    //         $contact = $this->contactService->createContact(
    //             $contactDTO,
    //             $request->user()->id
    //         );

    //         return response()->json([
    //             'data' => $contact,
    //             'success' => 'Contact created successfully'
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Contact creation failed: ' . $e->getMessage()
    //         ], 422);
    //     }
    // }
    
    // public function liste(Request $request)  
    // {  
    //     $contacts = Contact::query()  
    //         ->when($request->searchQuery, function ($query, $searchQuery) {  
    //             return $query->where('nom', 'like', '%' . $searchQuery . '%');  
    //         })  
    //         ->latest()  
    //         ->paginate(2);  

    //     return response()->json($contacts, 200);  
    // }  
    // public function update(UpdateContactRequest $request, $id)
    // {
    //     // Les données validées sont accessibles via $request->validated()
    //     $validatedData = $request->validated();
    //     $dto = new ContactUpdateDTO($validatedData['nom'], $validatedData['email']);

    //     try {
    //         $contact = $this->contactService->updateContact($id, $dto);
    //         return response()->json($contact, 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => $e->getMessage()], 404);
    //     }
    // }
    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'nom' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //     ]);

    //     $dto = new ContactUpdateDTO($validatedData['nom'], $validatedData['email']);

    //     try {
    //         $contact = $this->contactService->updateContact($id, (array) $dto);
    //         return response()->json($contact, 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => $e->getMessage()], 404);
    //     }
    // }
    // public function show($id)   
    // {  
    //     $contact = Contact::find($id);  
    //     if (!$contact) {  
    //         return response()->json(['message' => 'Contact non trouvé'], 404);  
    //     }  
    //     return response()->json($contact);  
    // }  

    // public function update(UpdateContactRequest $request, $id)  
    // {  
    //     $contact = Contact::findOrFail($id);  
    //     $contact = $this->ContactServiceInterface->updateContact($contact, $request->validated());   

    //     return response()->json(['data' => $contact, 'success' => 'Contact updated successfully']);  
    // }  

    // public function destroy($id)  
    // {  
    //     $contact = Contact::find($id);  
    //     if (!$contact) {  
    //         return response()->json(['error' => 'Contact not found'], 404);  
    //     }  
    //     $this->ContactServiceInterface->deleteContact($contact);  
    //     return response()->json(['success' => 'Contact deleted successfully']);  
    // }  

    // public function toggleFavorite($id)  
    // {  
    //     $contact = Contact::find($id);  
    //     if (!$contact) {  
    //         return response()->json(['error' => 'Contact not found'], 404);  
    //     }  
        
    //     $contact->favorite = !$contact->favorite;  
    //     $contact->save();  
    //     return response()->json($contact);  
    // }  
// }





// namespace App\Http\Controllers;

// use App\Models\Contact;
// use App\Services\ContactService;
// use App\Http\Requests\StoreContactRequest;
// use App\Http\Requests\UpdateContactRequest;
// use Illuminate\Http\JsonResponse;
// use Illuminate\Http\Request;

// class ContactController extends Controller
// {
//     public function __construct(
//         private readonly ContactService $contactService
//     ) {}

//     public function index(Request $request): JsonResponse
//     {
//         $contacts = $this->contactService->searchContacts(
//             searchQuery: $request->get('searchQuery'),
//             userId: $request->user()->id
//         );
        
//         return response()->json($contacts);
//     }

//     public function store(StoreContactRequest $request): JsonResponse
// {
//     try {
//         $contact = $this->contactService->createContact([
//             ...$request->validated(),
//             'user_id' => $request->user()->id
//         ]);

//         return response()->json([
//             'data' => $contact,
//             'message' => 'Contact created successfully'
//         ], 201);
//     } catch (\Exception $e) {
//         //\Log::error($e->getMessage());
//         return response()->json([
//             'message' => 'Error creating contact: ' . $e->getMessage()
//         ], 500);
//     }
// }

    // public function store(StoreContactRequest $request): JsonResponse
    // {
    //     $contact = $this->contactService->createContact([
    //         ...$request->validated(),
    //         'user_id' => $request->user()->id
    //     ]);

    //     return response()->json([
    //         'data' => $contact,
    //         'message' => 'Contact created successfully'
    //     ], 201);
    // }

//     public function show(Contact $contact): JsonResponse
//     {
//         return response()->json($contact->load('group'));
//     }

//     public function update(UpdateContactRequest $request, Contact $contact): JsonResponse
//     {
//         // $this->authorize('update', $contact);
        
//         $contact = $this->contactService->updateContact(
//             contact: $contact,
//             data: $request->validated()
//         );

//         return response()->json([
//             'data' => $contact,
//             'message' => 'Contact updated successfully'
//         ]);
//     }

//     public function destroy(Contact $contact): JsonResponse
//     {
//         // $this->authorize('delete', $contact);
        
//         $this->contactService->deleteContact($contact);

//         return response()->json([
//             'message' => 'Contact deleted successfully'
//         ]);
//     }

//     public function toggleFavorite(Contact $contact): JsonResponse
//     {
//         // $this->authorize('update', $contact);
        
//         $contact->update(['favorite' => !$contact->favorite]);

//         return response()->json($contact);
//     }
// }






// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Contact;
// use App\Models\User;
// use Illuminate\Support\Facades\Storage;
// use App\Services\ContactService;
// use App\Http\Requests\StoreContactRequest; 
// use App\Http\Requests\UpdateContactRequest;

// class ContactController extends Controller
// {
//     protected $contactService;

//     public function __construct(ContactService $contactService)
//     {
//         $this->contactService = $contactService;
//     }
//     public function index(Request $request)
//     {
//         $contacts = $this->contactService->searchContacts($request->get('searchQuery'), $request->user()->id);
//         return response()->json($contacts, 200);
//     }
//     public function store(UpdateContactRequest $request) 
//     {
//         $contact = $this->contactService->createContact($request->validated());
//         return response()->json(['data' => $contact, 'success' => 'Contact created successfully']);
//     }  
//     public function liste(Request $request)
//     {
//         $contact = Contact::query();
//         if($request->searchQuery != ''){
//             $contact = Contact::where('name', 'like', '%'.$request->searchQuery.'%');
//         }
//         $contacts = $contact->latest()->paginate(2);
//         return response()->json([
//             $contacts
//         ], 200);
//     }

    

// public function store(Request $request)  
// { 
    
//     $user = $request->user(); 
//     $contact = new Contact();  
//     $contact->nom = $request->nom;  
//     $contact->prenom = $request->prenom;  

//     if ($request->hasFile('avatar')) {  
//         try {  
//              $imagePath = $request->file('avatar')->store('upload', 'public');  
 

//              $contact->image = "http://localhost:8000/storage/$imagePath";   
//         } catch (\Exception $e) {  
//             return response()->json(['error' => 'Image upload failed: ' . $e->getMessage()], 422);  
//         }  
//     } else {  
//         $contact->image = "no-image.jpg";  
//     }  

//     $contact->email = $request->email;  
//     $contact->numeroTelephone = $request->telephone;  
//     $contact->user_id = $user->id;   
//     $contact->groupe_id = $request->selectedGroup;  

//     $contact->save();  

//     return response()->json(['data' => $contact, 'success' => 'Contact created successfully']);

// }

// public function show($id) {  
//     $contact = Contact::find($id);  
    
//     if (!$contact) {  
//         return response()->json(['message' => 'Contact non trouvé'], 404);  
//     }  

//     return response()->json($contact);  

   

// }

// public function update(UpdateContactRequest $request, $id)  
// {  
//     $contact = Contact::findOrFail($id);
//     $contact = $this->contactService->updateContact($contact, $request->validated()); 

//     return response()->json(['data' => $contact, 'success' => 'Contact updated successfully']);
 
//     // $validatedData = $request->validate([  
//     //     'nom' => 'required|string|max:255',  
//     //     'prenom' => 'required|string|max:255',  
//     //     'email' => 'required|email|max:255',  
//     //     'telephone' => 'required|string|max:20', 
//     //     // 'selectedGroup' => 'nullable|exists:groups,id', 
//     //     'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  
//     // ]);  
    
   
//     // $contact = Contact::findOrFail($id);  
    
    
//     // $contact->nom = $validatedData['nom'];  
//     // $contact->prenom = $validatedData['prenom'];  
//     // $contact->email = $validatedData['email'];  
//     // $contact->numeroTelephone = $validatedData['telephone'];  
    
    
//     // if (isset($validatedData['selectedGroup'])) {  
//     //     $contact->groupe_id = $validatedData['selectedGroup'];   
//     // }  
    
   
//     // if ($request->hasFile('avatar')) {  
//     //     try {  
             
//     //         $imagePath = $request->file('avatar')->store('upload', 'public');  
//     //         $contact->image = "http://localhost:8000/storage/$imagePath";  
//     //     } catch (\Exception $e) {  
//     //         return response()->json(['error' => 'Image upload failed: ' . $e->getMessage()], 422);  
//     //     }  
//     // }  
    
    
//     // $contact->save();  

//     // return response()->json(['data' => $contact, 'success' => 'Contact updated successfully']);  
// }

// public function destroy($id)
// {
//     // $contact = Contact::find($id);
//     //     if (!$contact) {
//     //         return response()->json(['error' => 'Contact not found'], 404);
//     //     }

//     //     $this->contactService->deleteContact($contact);
//     //     return response()->json(['success' => 'Contact deleted successfully']);

//         $contact = Contact::find($id);
//         if (!$contact) {
//             return response()->json(['error' => 'Contact not found'], 404);
//         }
//         $this->contactService->deleteContact($contact);
//         return response()->json(['success' => 'Contact deleted successfully']);
        
// }
    

//     public function addFavorite(Contact $contact)  
//     {  
//         $contact->favorite = true;  
//         $contact->save();  
//         return response()->json($contact);  
//     }  

//     public function removeFavorite(Contact $contact)  
//     {  
//         $contact->favorite = false;  
//         $contact->save();  
//         return response()->json($contact);  
//     } 

//     function unfavorite($id) {
//         $contact =  Contact::find($id);

//         $contact->is_favorite = 0;

//         $contact->save();

//         return response()->json([
//             'message' => "success"
//         ]);
//     }

//     function favorite($id) {
//         $contact =  Contact::find($id);

//         $contact->is_favorite = 1;

//         $contact->save();

//         return response()->json([
//             'message' => "success"
//         ]);
//     }

// }

