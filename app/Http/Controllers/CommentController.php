<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
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
            'data' => $comments
        ], 200);
        } catch (\Exception $message) {
            return response()->json([
                "Erreur : " => $message->getMessage(),
            ]);
        }
    }


    public function store(CommentRequest $request)
    {
        try {
            $comment = Comment::create([
                "user_id" => auth()->user()->id,
                "post_id" => $request['post_id'],
                "comment" => $request['comment']
            ]);

            return response()->json([
                'data' => $comment ,
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
            return response()->json(new CommentResource($comment), 200);
        } catch (\Exception $message) {
            return response()->json(["Erreur :" => $message->getMessage()], 403);
        }

    }


    public function update(CommentRequest $request, Comment $comment)
    {
        try {
            if (auth()->user()->id !==  $comment->user_id){
                return response()->json([
                    'Erreur :' => 'Seul l utilisateur peut modifier ce commentaire'
                ]);
            }
            $comment->update([
                "comment" => $request['comment']
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
            if (auth()->user()->id !==  $comment->user_id){
                return response()->json([
                    'Erreur :' => 'Seul l utilisateur peut supprimer ce commentaire'
                ]);
            }
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

            return response()->json($post_all);

        } catch (\Exception $message) {
            return response()->json([
                'Erreur' => $message->getMessage(),
            ], 500);
        }
    }
}
