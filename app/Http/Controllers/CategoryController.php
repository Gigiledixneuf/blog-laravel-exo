<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = CategoryResource::collection(Category::all());
            return response ()->json($categories);
        } catch (\Exception $message) {
            return response()->json(["message"=> $message->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            //Validator
            $validationData = $request->validate([
                "name"=> 'required',
                "description"=> 'required',
            ]
            );
    
            $category = Category::create([
                "name" => $validationData['name'],
                "description" => $validationData['description'],
                
            ]);
    
            return response()->json([
                'Message' => "Category ajouté avec success",
                'Category :' => $category ,
            ], 200);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
    }

   
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            //Validator
            $validationData = $request->validate([
                "name"=> 'required',
                "description"=> 'required',
            ]
            );
    
            $category->update([
                "name" => $validationData['name'],
                "description" => $validationData['description'],
                
            ]);
    
            return response()->json([
                'Message' => "Category modifié avec success",
                'Category :' => $category ,
            ], 200);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json(["Message : " => "Category supprimé"], 200);
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
    }
}
