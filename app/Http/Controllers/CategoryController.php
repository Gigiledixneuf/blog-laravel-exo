<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        try {
            $categories = CategoryResource::collection(Category::all());
            return response ()->json($categories, 200);
        } catch (\Exception $message) {
            return response()->json(["Erreur : "=> $message->getMessage()], 403);
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = Category::create([
                "name" => $request['name'],
                "description" => $request['description'],
            ]);
    
            return response()->json([
                'Message' => "Category ajouté avec success",
                'Category :' => $category ,
            ], 201);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
    }

   
    public function show(Category $category)
    {
        try {
            return response()->json(new CategoryResource($category), 200);
        } catch (\Exception $message) {
            return response()->json([
                "Erreur :" => $message->getMessage(),
            ]);
        }
        
    }
    


    public function update(CategoryRequest $request, Category $category)
    {
        try {
            
            $category->update([
                "name" => $request['name'],
                "description" => $request['description'],
            ]);
    
            return response()->json([
                'Message' => "Category modifié avec success",
                'Category :' => $category ,
            ], 201);
    
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
    }


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
