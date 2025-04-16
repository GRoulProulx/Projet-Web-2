<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Afficher le formulaire de connexion
        return view('auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validations des données du formulaire
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);
        // Authentification de l'utilisateur
        $credentials = $request->only('email', 'password');
        if(!Auth::validate($credentials)) {
            return redirect(route('connexion'))->withErrors(['email' => 'Courriel ou mot de passe incorrects'])->withInput();
        }

        // Authentification réussie et la connexion de l'utilisateur
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);
        TODO: // Définir la session de l'utilisateur (administrateur ou utilisateur) ICI ???


        return redirect()->intended(route('accueil'))->with('success', 'Vous êtes connecté');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Géré la déconnexion de l'utilisateur
        Session::flush();
        Auth::logout();
        return redirect(route('connexion'));
    }
}
