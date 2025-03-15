<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
   
    public function index()
    {
        return Article::all();
    }

   
    public function store(Request $request)
    {
        // Validation des données avant insertion
        $validatedData = $request->validate([
            'title' => 'required|unique:articles|max:255',
            'slug' => 'required|max:255',
            'photo' => 'required',
            'auteur' => 'required|max:255',
            'content' => 'required',
            'categorie' => 'required',
        ]);

        // Si la validation passe, on crée l'article en shhhhhhhhhhhhhh
        $article = Article::create([
            'title' => $validatedData["title"],
            'slug' => $validatedData["slug"],
            'photo' => $validatedData["photo"],
            'auteur' => $validatedData["auteur"],
            'content' => $validatedData["content"],
            'categorie' => $validatedData["categorie"],
        ]);

        if ($article) {
            $messageCreation = "Article crée avec success"; 
            // return ['article' => $article, 'message' => $messageCreation];
            return $messageCreation;

        } else {
            return "Erreur lors de la créeation de l'article";
        }

    }
    
  
    public function show(Article $article)
    {
        return $article;
    }

    
    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:articles|max:255',
            'slug' => 'required|max:255',
            'photo' => 'required',
            'auteur' => 'required|max:255',
            'content' => 'required',
            'categorie' => 'required',
        ]);
        $article->update([
            'title' => $validatedData["title"],
            'slug' => $validatedData["slug"],
            'photo' => $validatedData["photo"],
            'auteur' => $validatedData["auteur"],
            'content' => $validatedData["content"],
            'categorie' => $validatedData["categorie"],
        ]);

        return $article;
    }

    
    public function destroy(Article $article)
    {
        $article->delete();
    }
}
