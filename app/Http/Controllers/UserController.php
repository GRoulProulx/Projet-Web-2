<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Méthode pour afficher la liste des utilisateurs
     * @return \Illuminate\View\View La vue de la liste des utilisateurs.
     */
    public function index()
    {
        //Récupère tous les utilisateurs depuis la base de données
        if (!Auth::user()->role_id == 1) {
            abort(403, 'Vous n\'avez pas les droits pour accéder à cette page.');
        }
        $users = User::all();
        return view('user.index', ['users' => $users]);
    }

    /**
     * Méthode pour afficher le formulaire d'inscription
     * @return \Illuminate\View\View La vue du formulaire d'inscription.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Méthode pour enregistrer un nouvel utilisateur
     * @param Request $request Les données du formulaire d'inscription.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page de connexion avec un message de succès.
     */
    public function store(Request $request)
    {
        //Validation des données du formulaire
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
        ]);

        //Création d'un nouvel utilisateur
        $user = new User();
        $user->fill($request->all());
        $user->save();

        // Après l'inscription, on connecte automatiquement l'utilisateur
        auth()->login($user);
        return redirect()->route('cellar.index')->with('success', 'Inscription réussie! Créer votre premier cellier.');
    }

    /**
     * Méthode pour supprimer un utilisateur
     * @param string $id L'identifiant de l'utilisateur.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page de création d'utilisateur avec un message de succès.
     */
    public function destroy(string $id) {}

    /**
     * Méthode pour afficher le formulaire d'oubli de mot de passe
     * @return \Illuminate\View\View La vue du formulaire d'oubli de mot de passe.
     */
    public function forgot()
    {
        return view('user.forgot');
    }

    /**
     * Envoie un lien de réinitialisation de mot de passe à l'utilisateur.
     * Génère un token temporaire et l'enregistre dans la base de données.
     *
     * @param Request $request Les données du formulaire contenant l'adresse email.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page de connexion avec un message de succès.
     */
    public function email(Request $request)
    {
        //Validation des données du formulaire
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        //Récupération de l'utilisateur
        $user = User::where('email', $request->email)->first();
        $userId = $user->id;
        $tempPassword = str::random(45);
        $user->temp_password = $tempPassword;
        $user->save();

        //Envoi de l'email
        $to_name = $user->name;
        $to_email = $request->email;
        $body = "<a href='" . route('user.reset', [$userId, $tempPassword]) . "'>Cliquez ici pour réinitialiser votre mot de passe</a>";

        Mail::send('user.mail', ['name' => $to_name, 'body' => $body], function ($message) use ($to_email) {
            $message->to($to_email)->subject('Réinitialisation de mot de passe');
        });
        return redirect(route('login'))->with('success', 'Un courriel contenant les instructions a été envoyé à votre adresse email.');
    }

    /**
     * Affiche le formulaire de réinitialisation de mot de passe si le token est valide.
     * Redirige vers la page d'oubli de mot de passe en cas d'échec.
     *
     * @param User $user L'utilisateur pour lequel le mot de passe doit être réinitialisé.
     * @param string $token Le token temporaire pour valider la réinitialisation.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse La vue du formulaire ou une redirection en cas d'erreur.
     */
    public function reset(User $user, $token)
    {
        if ($user->temp_password === $token) {
            return view('user.reset');
        }
        return redirect(route('user.forgot'))->withErrors('Les informations fournies ne sont pas valides.');
    }

    /**
     * Met à jour le mot de passe de l'utilisateur si le token est valide.
     * Réinitialise le token temporaire après la mise à jour.
     *
     * @param Request $request Les données du formulaire de réinitialisation.
     * @param User $user L'utilisateur pour lequel le mot de passe doit être mis à jour.
     * @param string $token Le token temporaire pour valider la réinitialisation.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page de connexion avec un message de succès ou d'erreur.
     */
    public function resetUpdate(Request $request, User $user, $token)
    {
        if ($user->temp_password === $token) {
            //Validation des données du formulaire
            $request->validate([
                'password' => 'required|min:5|confirmed',
            ]);

            //Mise à jour du mot de passe
            $user->password = Hash::make($request->password);
            $user->temp_password = null;
            $user->save();
            return redirect(route('login'))->with('success', 'Votre mot de passe a été réinitialisé avec succès. Veuillez vous connecter.');
        }
        return redirect(route('user.forgot'))->withErrors('Les informations fournies ne sont pas valides.');
    }
}
