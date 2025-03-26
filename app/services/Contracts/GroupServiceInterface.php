<?php

namespace App\Services\Contracts;

use App\Models\Group;

interface GroupServiceInterface
{
    public function searchGroups($searchQuery);
    public function createGroup(array $data);
    public function updateGroup(Group $group, array $data);
    public function deleteGroup(Group $group);
    public function getAllGroups();
    public function findGroupById($id);
}
