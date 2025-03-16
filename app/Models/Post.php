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
        // La methode belongsTo indique que ce modele Post appartient à un autre modele User
        // Le nom de la methode user represente la relation entre les deux modeles.
        //bon en gros cette methode servira a recuperer toutes les infos de l'utilisateur 
        return $this->belongsTo(User::class); 
    }
}
