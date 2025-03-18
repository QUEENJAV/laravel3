<?php

namespace App\Http\Controllers;

use App\Models\User;  
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Str;   // Import de Str  
use Illuminate\Support\Facades\DB; // Import de DB  
use Carbon\Carbon; // Pour une utilisation propre de "now()" (si nécessaire)  
use Illuminate\Support\Facades\Auth;  
use Illuminate\Validation\ValidationException; 

class AuthController extends Controller
{public function register(Request $request)  
    {  
        $request->validate([  
            'name' => 'required|string|max:255',  
            'email' => 'required|string|email|unique:users|max:255',  
            'password' => 'required|string|min:6',  
        ]);  

        $user = User::create([  
            'name' => $request->name,  
            'email' => $request->email,  
            'password' => Hash::make($request->password),  
        ]);  

        return response()->json($user, 201);  
    }  
  
    public function login(Request $request)  
    {  
        
        $credentials = $request->only('email', 'password');  

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('AppToken')->plainTextToken;

            return response()->json([
                'token' => $token
            ]);
        }
        else{
            return response()->json([
                'message' > "Invalid Credentials",
            ], 401);
        }
       
        
    } 
    public function me(Request $request)  
    {  
        return response()->json($request->user());  
    }

    public function logout()  
    {  
       try {  
           Auth::logout();  
           return response()->json(['message' => 'Déconnexion réussie'], 200);  
       } catch (\Exception $e) {  
           return response()->json(['error' => 'Erreur de déconnexion', 'message' => $e->getMessage()], 500);  
       }  
    } 

    
    public function resetPasswordRequest(Request $request)  
{  
     
    $request->validate([  
        'email' => 'required|email|exists:users,email',  
    ]);  

   
    $token = Str::random(60);  

    
    DB::table('password_resets')->insert([  
        'email' => $request->email,  
        'token' => $token,  
        'created_at' => now(), 
    ]);  

      
    return response()->json(['message' => 'Reset token generated successfully.']);  
    }  

}
