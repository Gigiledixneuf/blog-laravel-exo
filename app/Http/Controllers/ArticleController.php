<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  Article::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Apres je dois utiliser la methode create, validator, comment aploder un ficher, arranger le model, storage file, comment afficher la photo save et reource 
        $article = new Article(); //Création d'un nouvel article

        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->photo = $request->photo;
        $article->auteur = $request->auteur;
        $article->content = $request->content;

        $article->save(); //Sauvegarde dans la BDD
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return $article;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
