<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfilResource;
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{

    public function index()
    {
        try {
            $profil  = ProfilResource::collection(Profil::all());
            return response()->json([
                "data" => $profil
            ]);
        }catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 500);
        }

    }


    public function store(Request $request)
    {
        try {
            $user =  auth()->user();
            $validated = $request->validate([
                'bio' => 'required',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imagePath = $request->file('image')->store('uploads/users', 'public');

            if ($user->profil) {
                $user->profil->delete();
            }

            $profil = Profil::create([
                'user_id' => $user->id,
                'bio' => $validated['bio'],
                'image' => $imagePath,
            ]);

            return response()->json([
                "data" => $profil
            ]);
        }catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 500);
        }

    }


    public function show(Profil $profil)
    {
        try {
            return response()->json([
                "data" => new ProfilResource($profil)
            ]);
        }catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request, Profil $profil)
    {
        try {
            $validated = $request->validate([
                'bio' => 'required',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $profil->update([
                'bio' => $validated['bio'],
                'image' => $validated['image'],
            ]);

            return response()->json([
                "data" => $profil
            ]);
        }catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 500);
        }

    }


    public function destroy(Profil $profil)
    {
        try {
            $profil->delete();
            return response()->json([
                "message" => "Profil supprimé"
            ]);
        }catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 500);
        }
    }
}
