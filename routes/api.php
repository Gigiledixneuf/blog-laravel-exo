<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


// Dans un router group pour les routes protégées en gros
Route::middleware('auth:sanctum')->group(function () {
    // CRUD des utilisateurs
    Route::apiResource('/users', AuthController::class);

    // Gestion des posts CRUD et autres
    Route::apiResource('/posts', PostController::class);
    Route::get('/postOneUser', [PostController::class, 'postsOfOneUser']);
    Route::get('/latestPosts', [PostController::class, 'latestPosts']);
    Route::get('/postOnecategory', [PostController::class, 'postsOfOneCategory']);
    Route::post('/likePost', [LikeController::class,'store']);

    //Gestion CRUD commentaires
    Route::apiResource('/comments', CommentController::class);
    Route::get('/commentOneUser', [CommentController::class, 'commentOfOneUser']);

    //Gestion CRUD categories
    Route::apiResource('/categories', CategoryController::class);

    //Gestion Tags
    Route::apiResource('/tags', \App\Http\Controllers\TagController::class);

    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']); // Déconnexion
});


// Connexion
Route::post('/login', [AuthController::class, 'login']); // Connexion
// Inscription
Route::post('/register', [AuthController::class, 'store']); // Inscription
