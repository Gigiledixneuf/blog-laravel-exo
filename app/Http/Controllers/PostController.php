<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        //$post = Post::orderBy("id","desc")->paginate(10);
        try {
            $post_all = Post::with('user')->get();
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
                "user_id" => auth()->user()->id,
            ]);
    
            return response()->json([
                'Message' => "Post crée avec success",
                'post' => $post , //->id,
            ], 200);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ]);
        }
    }


    public function show(Post $post)
    {
        try {
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
}
