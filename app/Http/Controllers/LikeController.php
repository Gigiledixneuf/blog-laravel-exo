<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function index()
    {
        return Like::all();
    }


    public function store(LikeRequest $request)
    {
        $postId = $request->post_id;
        $userId = auth()->id();

        // Vérifier si l'utilisateur a déjà liké ce post
        $like = Like::where('user_id', $userId)
                    ->where('post_id', $postId)
                    ->first();

        if ($like) {
            // Si un like existe, on le supprime (unlike)
            $like->delete();
            return response()->json([
                "message" => "Like retiré",
                "Like" => $like,
                "likes_count" => Like::where('post_id', $postId)->count(),
            ]);
        } else {
            // Sinon  on va rajouter un like
            Like::create([
                "user_id" => $userId,
                "post_id" => $postId,
            ]);
            return response()->json([
                "message" => "Like ajouté",
                "Like" => $like,
                "likes_count" => Like::where('post_id', $postId)->count(),
            ]);
        }
   }


}
