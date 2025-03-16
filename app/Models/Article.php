<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    
    // Les champs qui peuvent être remplis via le remplissage de masse
    protected $fillable = ['title', 'slug', 'photo', 'auteur', 'content', 'categorie'];
}
