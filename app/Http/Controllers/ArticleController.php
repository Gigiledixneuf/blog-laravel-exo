<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
   
    public function index()
    {
        try {
            $articles = Article::all();
            return response()->json($articles);
        } catch (\Exception $message) {
            return response()->json(["Erreur: "=> $message->getMessage()]);
        }
        
    }

   
    public function store(Request $request)
    {
        try {
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

        return response()->json([
            "Message" => "Article crée avec succèss",
            "Article" => $article->id,
        ]);

        } catch (\Exception $message) {
            return response()->json([
                "Erreur: " => $message->getMessage(),
            ]);
        }
        
    }
    
  
    public function show(Article $article)
    {
        try {
            return response()->json($article);
        } catch (\Exception $message) {
            return response()->json([
                "Erreur: " => $message->getMessage(),
            ]);
        }
        
    }

    
    public function update(Request $request, Article $article)
    {
        try {
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
    
            return response()->json([
                "message"=> "Article Modifié",
                "Article" => $article->id,
            ],200);

        } catch (\Exception $message) {
            return response()->json([
                "Erreur: "=> $message->getMessage(),
            ]);
        }
        
    }

    
    public function destroy(Article $article)
    {
        try {
            $article->delete();
            return response()->json([
                "Message"=> "Utilisateur supprimé",
            ]);
        } catch (\Exception $message) {
            return response()->json([
                "Erreur: " => $message->getMessage(),
            ]);
        }
        
    }
}
