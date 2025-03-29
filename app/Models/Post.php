<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; // Si tu as besoin de cette fonctionnalité, sinon, tu peux l'ignorer

class Post extends Model
{
    use HasFactory;  // Si tu utilises des factories pour générer des instances de modèles


    protected $fillable = ['title', 'content', 'imageUrl', 'user_id'];

        //Fonction pour obtenir l'utilisateur associé à ce post.
        //Cela correspond à la clé étrangère 'user_id'.
        //La relation 'belongsTo' signifie qu'un post appartient à un utilisateur.

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
}
