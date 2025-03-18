<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  

class Contact extends Model
{
    use HasFactory;  
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'numeroTelephone',
        'user_id',
        'groupe_id',
        'is_favorite',
        'image'
    ];

    // protected $fillable = ['nom', 'prenom','image', 'email', 'numeroTelephone', 'groupe_id'];  

    public function user()  
    {  
        return $this->belongsTo(User::class);  
    }  

    public function group()  
    {  
        return $this->belongsTo(Group::class, 'groupe_id');  
    }  

    public function getNomComplet()  
    {  
        return "{$this->prenom} {$this->nom}";  
    }  
}
