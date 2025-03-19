<?php

namespace App\Http\Controllers;

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


    public function store(Request $request)
    {
       
        try {
            //Validator
            $validationData = $request->validate([
                "title"=> 'required|max:255',
                "content"=> 'required',
                "imageUrl"=> 'required|max:255',
            ]
            );
    
            $post = Post::create([
                "title" => $validationData['title'],
                "content" => $validationData['content'],
                "imageUrl" => $validationData['imageUrl'],
                //recuperer et inserer le post en fonction de l'id de l'utilisateur 
                "user_id" => auth()->user()->id, 
                "user_name" => auth()->user()->name,
            ]);
    
            return response()->json([
                'Message' => "Post crée avec success",
                'post' => $post , //->id,
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
            $post->load('user', 'comments');
            return response()->json($post);
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
        
    }


    public function update(Request $request, Post $post)
    {
        try {
            $validationData = $request->validate([
                "title"=> 'required|max:255',
                "content"=> 'required',
                "imageUrl"=> 'required|max:255',
            ]
            );
    
            $post->update([
                "title" => $validationData['title'],
                "content" => $validationData['content'],
                "imageUrl" => $validationData['imageUrl'],
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
            $post_all = PostResource::collection(Post::where('user_id', auth()->id())->get());
    
            return response()->json([
                'Post' => $post_all,
            ]);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur' => $message->getMessage(),
            ], 500);
        }
    }
}
