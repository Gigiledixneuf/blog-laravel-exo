<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
   public function getArticle()
   {
    $articles = Article::all();

    return view("articles", compact("articles"));

   }

}
