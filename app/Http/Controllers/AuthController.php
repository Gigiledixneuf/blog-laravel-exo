<?php

namespace App\Http\Controllers;

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
            return response()->json($users);
        } catch (\Exception $message) {
            return response()->json(["Erreur : "=> $message->getMessage()]);
        }
       
    }

    

    // Methode store==================================================================
    public function store(Request $request)
    {
        try {
             // Validatooooooooor ======
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        // Création userss ========
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Création du token d'authentification d useeeerrr====
        //createToken sert a creer le token 
        //plainTextToken est utilisé pour renvoye un token plus claire
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ], 201);

        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ]);
        }
       
    }

    // Geeet one userr===============================================================
    public function show(User $user)
    {
        try {
            return response()->json($user);
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : '=> $message->getMessage(),
            ]);
        }
        
    }

    // MAJ useeeer ==================================================================
    public function update(Request $request, User $user)
    {
        try {
            // Validatooooor update
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Update useeeere
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
        ]);

        return response()->json($user);

        } catch (\Exception $message) {
            return response()->json([
                "Erreur : " => $message->getMessage(),
            ]);
        }
        
    }

    // methode deleetee===================================================================
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'Utilisateur supprimé'], 200);
        } catch (\Exception $message) {
           return response()->json(['Erreur : ' => $message->getMessage()], 500);
        }
       
    }

    // LOGIINNN ===========================================================================
    public function login(Request $request)
    {
        // Validatooooor login avec make 
        $request->validate([
           'email' => 'required|email', 
           'password' => 'required|min:6',
        ]);


        // Authentification ou on recupération des donnees d'authentification (email et mot de passe)
        $Authentification = $request->only(['email', 'password']);


        try {
           // Tentative d'authentification avec les données fournies
           //Si echec on renvoie l'erreur
        if (!auth()->attempt($Authentification)) {
            return response()->json(['Erreur : ' => 'Email ou mot de passe incorrect'], 403);
        }

        // Si l'authentification réussie, on récupère l'utilisateur connecté
        $user = auth()->user();

        // Création du token d'authentification pour l'utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;


        // Récupérer informations-utilisateur connecté et retourner le token 
        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'message' => 'Connexion réussie',
        ], 200);

        } catch (\Exception $message) {
            return response()->json([
                'Erreur : ' => $message->getMessage(),
            ], 403);
        }
        
    }

    // Logout ou deconnexiooon ================================================================
    public function logout(Request $request)
    {
        //suppression du token 
        //currentAccessToken = token en cours et Supprime uniquement le token de la requête
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Déconnexion réussie'], 200);
        } catch (\Exception $message) {
            return response()->json([
                'Erreur : '=> $message->getMessage(),
            ], 403);
        }
        
    }
    
}
