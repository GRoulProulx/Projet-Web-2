<?php

namespace App\Http\Controllers;

use App\Models\Cellar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CellarController extends Controller
{
    // TODO: Vérifier l'authentification de l'utilisateur avant d'accéder aux méthodes de ce contrôleur

    /**
     * Afficher les celliers de l'utilisateur.
     */
    public function index()
    {
        $cellars = Cellar::where('user_id', auth()->id())->get();
        return view('cellar.index', compact('cellars'));
        /* return view('cellar.index'); */
    }

    /**
     * Afficher le formulaire pour créer un cellier.
     */
    public function create()
    {
        return view('cellar.create');
    }

    /**
     * Créer un nouveau cellier et valider les données.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate(
            [
                'name' => 'required|string|max:191'
            ]
        );

        // Créer le cellier
        $cellar = Cellar::create([
            'name' => $request->name,
            'user_id' => Auth::user()->id
        ]);

        // Rediriger vers la page du cellier créé
        return redirect()->route('cellar.show', $cellar->id)->with('success', 'Cellier créé avec succès !');
    }

    /**
     * Afficher le cellier spécifié.
     */
    public function show(Cellar $cellar)
    {
        return view('cellar_bottle.show', compact('cellar'));
    }

    /**
     * Afficher le formulaire pour modifier le cellier.
     */
    public function edit(Cellar $cellar)
    {
        return view('cellar.edit', compact('cellar'));
    }

    /**
     * Modifier le cellier spécifié et valider les données.
     */
    public function update(Request $request, Cellar $cellar)
    {
        // Valider les données du formulaire
        $request->validate(
            [
                'name' => 'required|string|max:191'
            ]
        );

        // Mettre à jour le cellier
        $cellar->update([
            'name' => $request->name
        ]);

        // Rediriger vers la page du cellier modifié
        return redirect()->route('cellar.show', $cellar->id)->with('success', 'Cellier modifié avec succès !');
    }

    /**
     * Supprimer le cellier spécifié.
     */
    public function destroy(Cellar $cellar)
    {
        // Supprimer le cellier
        $cellar->delete();

        // Rediriger vers la liste des celliers
        return redirect()->route('cellar.index')->with('success', 'Cellier supprimé avec succès !');
    }
}
