<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


// Dans un router group pour les routes protégées en gros 
Route::middleware('auth:sanctum')->group(function () {
    // CRUD des utilisateurs
    Route::apiResource('/users', AuthController::class);

    // Recuperer les posts de l'utilisateur connecté
    Route::get('/postOneUser', [PostController::class, 'postsOfOneUser']);
    Route::get('/commentOneUser', [CommentController::class, 'postsOfOneUser']);

    // Gestion des posts CRUD et autres 
    Route::apiResource('/posts', PostController::class);

    //Gestion CRUD commentaires
    Route::apiResource('/comments', CommentController::class);

    Route::apiResource('/categorys', CategoryController::class);
    
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']); // Déconnexion
});

// Connexion
Route::post('/login', [AuthController::class, 'login']); // Connexion
// Inscription
Route::post('/register', [AuthController::class, 'store']); // Inscription


