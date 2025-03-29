<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Mockery\Exception;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tagsAll = TagResource::collection(Tag::all());
            return response()->json([
                'data' => $tagsAll
            ]);
        }
        catch (\Exception $message) {
            return response()->json([
                'Ereur' => $message->getMessage(),
            ], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        try {
            $tags = Tag::create([
                'name' => $request['name'],
                'description' => $request['description'],
            ]);

            return response()->json([
                'data' => $tags
            ]);
        }
        catch (\Exception $message) {
            return response()->json([
                'Ereur' => $message->getMessage(),
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        try {
            return response()->json(new TagResource($tag), 200);
        }
        catch (\Exception $message) {
            return response()->json([
                'Ereur' => $message->getMessage(),
            ], 500);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        try {
            $tag->update([
                'name' => $request['name'],
                'description' => $request['description'],
            ]);

            return  response()->json([
                'data' => $tag
            ]);
        }
        catch (\Exception $message) {
            return response()->json([
                'Ereur' => $message->getMessage(),
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
            return response()->json();
        }
        catch (\Exception $message) {
            return response()->json([
                'Ereur' => $message->getMessage(),
            ], 500);
        }

    }
}
