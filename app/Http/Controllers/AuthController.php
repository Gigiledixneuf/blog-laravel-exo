<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


use function Laravel\Prompts\error;

class AuthController extends Controller
{
    // Récupérer usersssss===========================================================
    public function index()
    {
        try {
            $users = User::all();
            return response()->json([
                'data' => $users
            ]);
        } catch (\Exception $message) {
            return response()->json([
                "error"=> $message->getMessage()
            ]);
        }

    }

    // Methode store==================================================================
    public function store(UserRequest $request)
    {
        try {
        // Création userss ========
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        // Création du token d'authentification d useeeerrr====
        //createToken sert a creer le token
        //plainTextToken est utilisé pour renvoye un token plus claire
        $token = $user->createToken('auth_token')->plainTextToken;
        $user=[ 'user' => $user, 'token' => $token];

        return response()->json([
            'data' => $user
        ], 201);

        } catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 403);
        }

    }

    // Geeet one userr===============================================================
    public function show(User $user)
    {
        try {
            return response()->json($user, 200);
        } catch (\Exception $message) {
            return response()->json([
                'error'=> $message->getMessage(),
            ], 403);
        }

    }

    // MAJ useeeer ==================================================================
    public function update(UserRequest $request, User $user)
    {
        try {

        // Update useeeere
        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'] ? Hash::make($request['password']) : $user->password,
        ]);

        return response()->json([
            'data' => $user
            ], 201);

        } catch (\Exception $message) {
            return response()->json([
                "error" => $message->getMessage(),
            ], 403);
        }

    }

    // methode deleetee===================================================================
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'Utilisateur supprimé'], 201);
        } catch (\Exception $message) {
           return response()->json(['error' => $message->getMessage()], 403);
        }

    }

    // LOGIINNN ===========================================================================
    public function login(LoginRequest $request)
    {

        // Authentification ou on recupération des donnees d'authentification (email et mot de passe)
        $Authentification = $request->only(['email', 'password']);


        try {
           // Tentative d'authentification avec les données fournies
           //Si echec on renvoie l'erreur
        if (!auth()->attempt($Authentification)) {
            return response()->json(['error' => 'Email ou mot de passe incorrect'], 403);
        }

        // Si l'authentification réussie, on récupère l'utilisateur connecté
        $user = auth()->user();

        // Création du token d'authentification pour l'utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;
        $user = [ 'user' => $user, 'token' => $token];


        // Récupérer informations-utilisateur connecté et retourner le token
        return response()->json([
            'data' => $user
        ], 201);

        } catch (\Exception $message) {
            return response()->json([
                'error' => $message->getMessage(),
            ], 500);
        }

    }

    // Logout ou deconnexiooon ================================================================
    public function logout(Request $request)
    {
        //suppression du token
        //currentAccessToken = token en cours et Supprime uniquement le token de la requête
        //tokens = tous les tokens de la requête
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Déconnexion réussie'], 200);
        } catch (\Exception $message) {
            return response()->json([
                'error'=> $message->getMessage(),
            ], 500);
        }
    }

}
