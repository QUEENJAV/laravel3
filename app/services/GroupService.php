<?php

namespace App\Services;
use App\Models\Group;
class GroupService implements GroupServiceInterface
{
     public function searchGroups($searchQuery)
     {
         $groups = Group::query();
 
         if (!empty($searchQuery)) {
             $groups->where('nom', 'LIKE', '%' . $searchQuery . '%');
         }
         return $groups->latest()->paginate(2);
     }
     public function createGroup(array $data)
     {
         return Group::create($data);
     }
     public function updateGroup(Group $group, array $data)
     {
         $group->update($data);
         return $group;
     }
     public function deleteGroup(Group $group)
     {
         $group->delete();
     }
 
     public function getAllGroups()
     {
         return Group::all();
     }
 
     
     public function findGroupById($id)
     {
         return Group::find($id);
     }
}
