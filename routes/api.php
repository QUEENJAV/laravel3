<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;  
use App\Http\Controllers\ContactController;  
use App\Http\Controllers\GroupController; 


Route::post('register', [AuthController::class, 'register']);  
Route::post('login', [AuthController::class, 'login']); 

Route::middleware('auth:sanctum')->group(function () {  
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::prefix('contacts')->group(function(){
        Route::get('/', [ContactController::class, 'index']);   
        Route::post('/', [ContactController::class, 'store']);   
        Route::get('/{id}', [ContactController::class, 'show']);  
        Route::put('/{id}', [ContactController::class, 'update']);  
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
        Route::post('/{contact}/updateFavoriteStatus', [ContactController::class, 'updateFavoriteStatus']);  
        Route::get('/{contact}/removeFavorite', [ContactController::class, 'removeFavorite']); 
        Route::get('/liste', [ContactController::class, 'liste']);
    });  
    Route::get('/liste', [GroupController::class, 'liste']); 
    Route::prefix('groups')->group(function(){
        Route::get('/', [GroupController::class, 'index']); 
        Route::post('/', [GroupController::class, 'store']);   
        Route::get('/{id}', [GroupController::class, 'show']); 
        Route::put('/{id}', [GroupController::class, 'update']); 
        Route::delete('/{id}', [GroupController::class, 'destroy']); 
    });
});
