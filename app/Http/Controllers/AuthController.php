<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
 
class AuthController extends Controller
{
    /**
     * Méthode pour afficher le formulaire de connexion
     * @return \Illuminate\View\View La vue du formulaire de connexion.
     */
    public function create()
    {
        // Afficher le formulaire de connexion
        return view('Auth.create');
    }

    /**
     * Méthode pour gérer la soumission du formulaire de connexion
     * @param Request $request Les données du formulaire de connexion.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page du catalogue ou affiche un message d'erreur.
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
            return redirect(route('login'))->withErrors('Email ou mot de passe invalide. Veuillez réessayer.'); 
        endif;
        // Authentification réussie et la connexion de l'utilisateur
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);
        
        //TODO: Rediriger l'utilisateur vers la future page d'accueil???
        return redirect()->intended('/bottles')->withSuccess('Connecté avec succès!');
    }

    /**
     * Méthode pour afficher le profil de l'utilisateur
     * @param string $id L'ID de l'utilisateur.
     * @return \Illuminate\View\View La vue du profil de l'utilisateur.
     */
    public function show(string $id)
    {
        if (Auth::user()->id != $id) {
            abort(403, 'Vous n\'avez pas les droits pour accéder à cette page.');
        }
        return view('auth.show', ['user' => $id]);
    }

    /**
     * Méthode pour afficher le formulaire d'édition du profil de l'utilisateur
     * @param string $id L'ID de l'utilisateur.
     * @return \Illuminate\View\View La vue du formulaire d'édition du profil de l'utilisateur.
     */
    public function edit(string $id)
    {
        if (Auth::user()->id != $id) {
            abort(403, 'Vous n\'avez pas les droits pour accéder à cette page.');
        }
        return view('auth.edit', ['user' => $id]);
    }

    /**
     * Méthode pour mettre à jour le profil de l'utilisateur
     * @param Request $request Les données du formulaire d'édition du profil.
     * @param string $id L'ID de l'utilisateur.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page du profil de l'utilisateur.
     */
    public function update(Request $request, string $id)
    {
        //Validation des données du formulaire
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:5|confirmed',
        ]);

        // si le mot de passe est fourni, on le hache
        if ($request->filled('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        } else {
            //on récupère le mot de passe actuel
            $user = User::find($id);
            $request->merge(['password' => $user->password]);
        }

        //Création d'un nouvel utilisateur
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('login')->withErrors('Utilisateur non trouvé.');
        }

        $user->fill($request->all());
        $user->save();

        return redirect()->route('auth.show', $id)->with('success', 'Informations mises à jour avec succès.');
    }

    /**
     * Méthode pour supprimer le profil de l'utilisateur
     * @param string $id L'ID de l'utilisateur.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page de connexion.
     */
    public function deleteProfile(string $id){
        $user = User::find($id);
        $user->delete();
        Session::flush();
        Auth::logout();
        return redirect(route('login'))->with('success', 'Votre compte a été supprimé avec succès.');
    }

    /**
     * Méthode pour se déconnecter de l'application
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page de connexion.
     */
    public function destroy()
    {
        // Géré la déconnexion de l'utilisateur
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
