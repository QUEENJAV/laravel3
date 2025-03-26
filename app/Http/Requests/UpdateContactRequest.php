<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        
        return true;
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'numeroTelephone' => 'sometimes|required|max:200',
            'selectedGroup' => 'sometimes|required|exists:groups,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_favorite' => 'nullable|boolean'
        ];
    }

    /**
     * Obtenez les messages d'erreur personnalisés pour les règles de validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email n\'est pas valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'numeroTelephone.required' => 'Le téléphone est obligatoire',
            'selectedGroup.required' => 'Le groupe sélectionné est obligatoire',
            'selectedGroup.exists' => 'Le groupe sélectionné est invalide',
            'avatar.image' => 'L\'avatar doit être une image',
            'avatar.mimes' => 'L\'avatar doit être un fichier de type: jpeg, png, jpg, gif, svg',
            'avatar.max' => 'L\'avatar ne doit pas dépasser 2048 kilooctets'
        ];
    }
}
