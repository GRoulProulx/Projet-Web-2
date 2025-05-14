<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cellar;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Récupère tous les utilisateurs depuis la base de données
        
        $users = User::all();        
        return view('user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
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

        return redirect()->route('login')->with('success', 'Inscription réussie! Veuillez vous connecter.');
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
        //
    }

    public function celliers()
    {
        return $this->hasMany(Cellar::class);
    }
    //TODO: Ajouter des méthodes pour l'oubli de mot de passe, la réinitialisation du mot de passe, etc.

    /**
     * Méthode pour afficher le formulaire d'oubli de mot de passe
     * @return \Illuminate\View\View
     */
    public function forgot() {
        return view('user.forgot');
    }

    /**
     * Méthode pour envoyer le lien de réinitialisation de mot de passe
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function email(Request $request){
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
        $body = "<a href='" . route('user.reset', [$userId, $tempPassword]) . "'>Cliquez ici pour recevoir un nouveau mot de passe</a>";

        Mail::send('user.mail', ['name' => $to_name, 'body' => $body], function($message) use ($to_email){
            $message->to($to_email)->subject('Réinitialisation de mot de passe');
        });
        return redirect(route('login'))->with('success', 'Un email de réinitialisation de mot de passe a été envoyé à votre adresse email.');
    }

    /**
     * Méthode pour afficher le formulaire de réinitialisation de mot de passe
     * @param User $user
     * @param string $token
     * @return \Illuminate\View\View
     * @throws \Illuminate\Http\RedirectResponse
     */
    public function reset(User $user, $token) {
        if ($user->temp_password === $token) {
            return view('user.reset');
        }
        return redirect(route('user.forgot'))->withErrors('Les informations fournies ne sont pas valides.');   
    }
}
