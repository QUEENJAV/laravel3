<?php  

namespace App\Http\Requests;  

use Illuminate\Foundation\Http\FormRequest;  



class StoreContactRequest extends FormRequest  
{  
    public function authorize(): bool  
    {  
        return true;  
    }  

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'numeroTelephone' => 'required|number|max:200',
            'selectedGroup' => 'required|exists:groups,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

//     public function rules(): array
// {
//     return [  
//         'nom' => 'required|string|max:255',  
//         'prenom' => 'required|string|max:255',  
//         'email' => 'required|email|max:255|unique:contacts,email',  
//         'numeroTelephone' => 'required|string|max:20', 
//         'selectedGroup' => 'nullable|exists:groups,id',
//         'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'  
//         //'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  
//     ];  
// }

public function messages(): array
{
    return [
        'nom.required' => 'Le nom est obligatoire',
        'prenom.required' => 'Le prénom est obligatoire',
        'email.required' => 'L\'email est obligatoire',
        'email.email' => 'L\'email n\'est pas valide',
        'email.unique' => 'Cet email est déjà utilisé',
        'numeroTelephone.required' => 'Le téléphone est obligatoire',
    ];
}
}