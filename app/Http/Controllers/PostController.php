<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\CommentResource;
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
                'data' =>  $post_all
            ]);

        } catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
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
                "user_id" => auth()->user()->id
            ]);

            $post->categories()->attach($request->categories);
            $post->tags()->attach($request->tags);

            $post->load('categories', 'tags');

            return response()->json([
                'data' => $post,
            ], 200);

        } catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 403);
        }
    }

    public function show(Post $post)
    {
        try {
            // Charger les commentaires
            $post->load('comments');

            // Transformer les données avec PostResource et CommentResource
            $formattedPost = new PostResource($post);
            $comments = CommentResource::collection($post->comments);

            return response()->json([
                'data' => [
                    'post' => $formattedPost,
                    'comments' => $comments
                ]
            ], 200);
        } catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 500);
        }

    }

    public function update(PostRequest $request, Post $post)
    {
        try {
            // Vérifiez si l'utilisateur authentifié est l'auteur du post
            if (auth()->user()->id !== $post->user_id) {
                return response()->json([
                    'Erreur' => 'Seul l\'auteur peut modifier ce post.',
                ], 403);
            }
            $post->update([
                "title" => $request['title'],
                "content" => $request['content'],
                "imageUrl" => $request['imageUrl'],
            ]);

            return response()->json([
                'post' => $post , //->id,
            ], 200);

        } catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 500);
        }
    }


    public function destroy(Post $post)
    {
        try {
            // Vérifiez si l'utilisateur authentifié est l'auteur du post
            if (auth()->user()->id !== $post->user_id) {
                return response()->json([
                    'error' => 'Vous n\'êtes pas autorisé à supprimer ce post.',
                ], 403);
            }

            // Supprimer le post
            $post->delete();
            return response()->json([
                'message' => 'Post supprimé avec succès',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function postsOfOneUser(){
        try {
            // Récupérer uniquement les articles de l'utilisateur connecté
            $postsOfOneUser = PostResource::collection(Post::where('user_id', auth()->id())->get());

            return response()->json([
                "data" => $postsOfOneUser
            ]);

        } catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 500);
        }
    }

    public function postsOfOneCategory()
    {
        try {
            // Récupérer l'ID de la catégorie depuis la requête
            $categoryId = request('category_id');

            // Vérifier si l'ID de la catégorie est présent
            if (!$categoryId) {
                return response()->json(['error' => 'Category ID is required'], 400);
            }

            // Récupérer les articles associés à la catégorie spécifiée
            $posts = Post::whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            })->get();

            // Formater la collection d'articles
            $postCollection = PostResource::collection($posts);

            return response()->json([
                "data" => $postCollection
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function latestPosts()
    {
        try {
            $latestPosts = Post::latest()->take(5)->get();
            $posts = PostResource::collection($latestPosts);

            return response()->json([
                "data" => $posts
            ]);
        } catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 500);
        }
    }

}
