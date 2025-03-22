<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PostController extends Controller
{

    public function index()
    {
        //
        try {
           $post_all = PostResource::collection(Post::all());
            return response()->json([
                'Message' => 'Liste recuperee avec success',
                'Post' => $post_all,
        ]);

        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ]);
        }
    }


    public function store(PostRequest $request)
    {
       
        try {
           
            $post = Post::create([
                "title" => $request['title'],
                "content" => $request['content'],
                "imageUrl" => $request['imageUrl'],
                //recuperer et inserer le post en fonction de l'id de l'utilisateur 
                "user_id" => auth()->user()->id, 
                "user_name" => auth()->user()->name,
            ]);

            $post->categories()->attach($request->category_id);
            $categories = $post->categories;
    
            return response()->json([
                'Message' => "Post crée avec success",
                'post' => $post , //->id,
                "categories" => $categories,
            ], 200);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
    }


    public function show(Post $post)
    {
        try {
            return response()->json(new PostResource($post), 200);
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
        
    }


    public function update(PostRequest $request, Post $post)
    {
        try {
            $post->update([
                "title" => $request['title'],
                "content" => $request['content'],
                "imageUrl" => $request['imageUrl'],
            ]);
    
            return response()->json([
                'Message' => "Post modfié avec success",
                'Post modifié' => $post , //->id,
            ], 200);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
    }


    public function destroy(Post $post)
    {
        try {
            $post->delete();
            return response()->json([
                'Message' => "Post supprimé avec success",
            ], 200);
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
    }

    public function postsOfOneUser(){
        try {
            // Récupérer uniquement les articles de l'utilisateur connecté
            $postsOfOneUser = PostResource::collection(Post::where('user_id', auth()->id())->get());
    
            return response()->json([
                'Post' => $postsOfOneUser,
            ]);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur' => $message->getMessage(),
            ], 403);
        }
    }
}
