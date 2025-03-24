<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;  
use App\Http\Controllers\ContactController;  
use App\Http\Controllers\GroupController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('register', [AuthController::class, 'register']);  
Route::post('login', [AuthController::class, 'login']); 
Route::post('/logout', [AuthController::class, 'logout']);  
Route::middleware('auth:sanctum')->group(function () {  
    // Route::post('/logout', [AuthController::class, 'logout']);  
    // Route::apiResource('contacts', ContactController::class);  
    // Route::apiResource('groups', GroupController::class); 

     Route::prefix('contacts')->group(function(){
        Route::get('/', [ContactController::class, 'index']);  
        Route::get('/{contact}/favorite', [ContactController::class, 'favorite']);  
        Route::get('/{contact}/unfavorite', [ContactController::class, 'unfavorite']);  
        Route::post('/', [ContactController::class, 'store']);   
        Route::get('/{id}', [ContactController::class, 'show']);  
        Route::put('/{id}', [ContactController::class, 'update']);  
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
        Route::post('/{contact}/updateFavoriteStatus', [ContactController::class, 'updateFavoriteStatus']);  
        Route::get('/{contact}/removeFavorite', [ContactController::class, 'removeFavorite']);
    });
 
    Route::get('/groups', [GroupController::class, 'index']);
    Route::get('/liste', [GroupController::class, 'liste']); 
    Route::post('/groups', [GroupController::class, 'store']);   
    Route::get('/groups/{id}', [GroupController::class, 'show']); 
    Route::put('/groups/{id}', [GroupController::class, 'update']);  
    Route::delete('/groups/{id}', [GroupController::class, 'destroy']);  
      

Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

    });  
