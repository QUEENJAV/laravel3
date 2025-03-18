<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Services\GroupService; 
use App\Http\Requests\StoreGroupRequest;

class GroupController extends Controller
{
    protected $groupService;
    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }
    public function index(Request $request)
    {
        try {
            $groups = $this->groupService->searchGroups($request->get('searchQuery'));

            if ($groups->isEmpty()) {
                return response()->json(['message' => 'Aucun groupe trouvé'], 404);
            }
            return response()->json($groups);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Une erreur est survenue'], 500);
        }
    }
    public function store(Request $request)
    {
        
        $request->StoreGroupRequest;
        $group = $this->groupService->createGroup($request->all());

        return response()->json(['success' => 'Group created successfully', 'data' => $group]);
    }

    public function show($id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json(['message' => 'Groupe non trouvé'], 404);
        }

        return response()->json($group);
    }

    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $this->groupService->updateGroup($group, $request->all());

        return response()->json(['success' => 'Group updated successfully']);
    }

    public function destroy($id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json(['message' => 'Groupe non trouvé'], 404);
        }

        $this->groupService->deleteGroup($group);

        return response()->json(['message' => 'Groupe supprimé avec succès']);
    }
    public function liste(Request $request)
    {
        $groups = Group::all();
        
        
        return response()->json([
            'data' => $groups
        ], 200);
    }

    


}
