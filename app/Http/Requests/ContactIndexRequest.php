<?php

namespace App\Http\Requests;

class ContactIndexRequest
{
    public function rules(): array
    {
        return [
            'searchQuery' => 'nullable|string|min:2',
            'per_page' => 'nullable|integer|min:1|max:100'
        ];
    }

    // public function getSearchQuery(): ?string
    // {
    //     return $this->get('searchQuery');
    // }

    // public function getPerPage(): int
    // {
    //     return $this->get('per_page', 2);
    // }
}
