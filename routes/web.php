<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function (){ 
    return "Hello world";
});

Route::get('/mespays', function () {
    return ["Rdc", "Sud", "Tchad", "Gabon"];
});

Route::get('/pays', function () {
    $pays = [
        ['nom'=> 'Rdc', 'capitale' => 'Kinshasa'],
        ['nom'=> 'Sud', 'capitale' => 'Kigali'],
        ['nom'=> 'Tchad', 'capitale' => 'Ndjamena'],
        ['nom'=> 'Gabon', 'capitale' => 'Libreville']
    ];
    return $pays;
    
});