<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use Illuminate\Http\Request;

class BottleController extends Controller
{

    // TODO: Ajouter les permissions pour que seul l'admin puisse accéder à ces routes ??

    /**
     * Afficher la liste des bouteilles.
     */
    public function index()
    {
        $bottles = Bottle::all();
        return view('bottle.index', compact('bottles'));
    }

    /**
     * Afficher le formulaire pour créer une bouteille.
     */
    public function create()
    {
        return view('bottle.create');
    }

    /**
     * Créer une nouvelle bouteille et valider les données.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate(
            [
                'name' => 'required|string|max:191',
                'image' => 'required|string|max:191',
                'price' => 'required|string|max:191',
                'type' => 'required|string|max:191',
                'format' => 'required|string|max:191',
                'country' => 'required|string|max:191',
                'code_saq' => 'required|string|max:191',
                'url' => 'required|string|max:191'
            ]
        );

        //Créer la bouteille
        $bottle = Bottle::create([
            'name' => $request->name,
            'image' => $request->image,
            'price' => $request->price,
            'type' => $request->type,
            'format' => $request->format,
            'country' => $request->country,
            'code_saq' => $request->code_saq,
            'url' => $request->url
        ]);

        return redirect()->route('bottle.show', $bottle->id)->with('success', 'La bouteille a été créé avec succès.');
    }

    /**
     * Afficher les détails d'une bouteille.
     */
    public function show(Bottle $bottle)
    {
        return view('bottle.show', ['bottle' => $bottle]);
    }

    /**
     * Afficher le formulaire pour modifier une bouteille.
     */
    public function edit(Bottle $bottle)
    {
        return view('bottle.edit', ['bottle' => $bottle]);
    }

    /**
     * Modifier une bouteille.
     */
    public function update(Request $request, Bottle $bottle)
    {
        // Valider les données du formulaire
        $request->validate(
            [
                'name' => 'required|string|max:191',
                'image' => 'required|string|max:191',
                'price' => 'required|string|max:191',
                'type' => 'required|string|max:191',
                'format' => 'required|string|max:191',
                'country' => 'required|string|max:191',
                'code_saq' => 'required|string|max:191',
                'url' => 'required|string|max:191'
            ]
        );

        //Mise à jour de la bouteille
        $bottle->update([
            'name' => $request->name,
            'image' => $request->image,
            'price' => $request->price,
            'type' => $request->type,
            'format' => $request->format,
            'country' => $request->country,
            'code_saq' => $request->code_saq,
            'url' => $request->url
        ]);

        return redirect()->route('bottle.show', $bottle->id)->with('success', 'La bouteille a été modifié avec succès.');
    }

    /**
     * Supprimer une bouteille.
     */
    public function destroy(Bottle $bottle)
    {
        $bottle->delete();
        return redirect()->route('bottle.index')->with('success', 'Bouteille supprimée avec succès.');
    }
}
