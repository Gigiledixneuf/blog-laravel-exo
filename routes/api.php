<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


// Dans un router group pour les routes protégées en gros 
Route::middleware('auth:sanctum')->group(function () {
    // CRUD des utilisateurs
    Route::apiResource('/users', AuthController::class);

    // Gestion des articles CRUD et autres 
    Route::apiResource('/articles', ArticleController::class);//CRUD

    // Gestion des posts CRUD et autres 
    Route::apiResource('/posts', PostController::class);

    //Gestion CRUD commentaires
    Route::apiResource('/comments', CommentController::class);
    
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']); // Déconnexion
});

// Connexion
Route::post('/login', [AuthController::class, 'login']); // Connexion
// Inscription
Route::post('/register', [AuthController::class, 'store']); // Inscription


