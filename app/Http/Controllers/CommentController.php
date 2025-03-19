<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        try {
            $comments = CommentResource::collection(Comment::all());
        return response()->json([
            'Comment' => $comments,
        ], 200);
        } catch (\Exception $message) {
            return response()->json([
                "Erreur : " => $message->getMessage(),
            ]);
        }
    }


    public function store(Request $request)
    {
        try {
            //Validator
            $validationData = $request->validate([
                "post_id"=> 'required|integer',
                "comment"=> 'required|string',
            ]
            );
    
            $comment = Comment::create([
                "user_id" => auth()->user()->id, 
                "post_id" => $validationData['post_id'],
                "comment" => $validationData['comment'],
                "user_name" => auth()->user()->name,
                
            ]);
    
            return response()->json([
                'Message' => "Commentaire ajouté avec success",
                'Comment' => $comment ,
            ], 200);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
    }


    public function show(Comment $comment)
    {
        try {
            $comment->load('user');
            return response()->json(["Comment : " => $comment], 200);
        } catch (\Exception $message) {
            return response()->json(["Erreur :" => $message->getMessage()], 403);
        }
        
    }

  
    public function update(Request $request, Comment $comment)
    {
        try {
            $validationData = $request->validate([
                "comment"=> 'required|string',
            ]
            );
    
            $comment->update([
                "comment" => $validationData['comment']
            ]);
    
            return response()->json([
                'Message' => "Commentaire modfié avec success",
                'Post modifié' => $comment , //->id,
            ], 200);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            $comment->delete();
            return response()->json(["Message" => "Commentaire supprimé"], 200);
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
        
    }

    public function commentOfOneUser(){
        try {
            // Récupérer uniquement les articles de l'utilisateur connecté
            $post_all = CommentResource::collection(Comment::where('user_id', auth()->id())->get());
    
            return response()->json([
                'Comments' => $post_all,
            ]);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur' => $message->getMessage(),
            ], 500);
        }
    }
}
