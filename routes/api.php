<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pays', function () {
    $pays = [
        ['pays' => 'Rdc', 'capitale' => 'Kinshasa'],
        ['pays' => 'Sud', 'capitale' => 'Kigali'],
        ['pays' => 'Tchad', 'capitale' => 'Ndjamena'],
        ['pays' => 'Gabon', 'capitale' => 'Libreville']
    ];
    return $pays;
});

Route::apiResource('articles', ArticleController::class);
