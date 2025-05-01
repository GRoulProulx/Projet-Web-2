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
        return view('Auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validations des données du formulaire
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|max:25',
        ]);

        // Authentification de l'utilisateur
        $credentials = $request->only('email', 'password');

        if (!Auth::validate($credentials)):
            return redirect(route('login'))->withErrors('email ou mot de passe invalide');
        endif;
        // Authentification réussie et la connexion de l'utilisateur
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);
        
        //TODO: Rediriger l'utilisateur vers la future page d'accueil???
        return redirect()->intended('/bottles')->withSuccess('Connecté avec succès!');
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
    public function destroy()
    {
        // Géré la déconnexion de l'utilisateur
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
