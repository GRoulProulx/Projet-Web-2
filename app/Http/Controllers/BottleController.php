<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use App\Models\Cellar;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CellarBottle;
use Illuminate\Support\Facades\Auth;

class BottleController extends Controller
{
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
        if (!Auth::user()->role_id == 1) {
            abort(403, 'Unauthorized action.');
        }
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
                'price' => 'required|decimal:2',
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
        // Récupérer le nom des celliers associés à l'utlisateur connecté
        if (auth()->check()) {
            $cellars = auth()->user()->cellars;
        } else {
            $cellars = [];
        }
        return view('bottle.show', ['bottle' => $bottle, 'cellars' => $cellars]);   
    }

    /**
     * Afficher le formulaire pour modifier une bouteille.
     */
    public function edit(Bottle $bottle)
    {
        if (!Auth::user()->role_id == 1) {
            return redirect()->route('bottle.index')->with('error', 'Vous n\'avez pas les droits pour modifier cette bouteille.');
        }
        return view('bottle.edit', ['bottle' => $bottle]);
    }

    /**
     * Modifier une bouteille.
     */
    public function update(Request $request, Bottle $bottle)
    {
        if (!Auth::user()->role_id == 1) {
            return redirect()->route('bottle.index')->with('error', 'Vous n\'avez pas les droits pour modifier cette bouteille.');
        }
        // Valider les données du formulaire
        $request->validate(
            [
                'name' => 'required|string|max:191',
                'image' => 'required|string|max:191',
                'price' => 'required|decimal:2',
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
        if (!Auth::user()->role_id == 1) {
            return redirect()->route('bottle.index')->with('error', 'Vous n\'avez pas les droits pour modifier cette bouteille.');
        }

        $bottle->delete();
        return redirect()->route('bottle.index')->with('success', 'Bouteille supprimée avec succès.');
    }

    /**
     * Ajouter une bouteille au cellier.
     */
    public function addToCellar(Request $request, Bottle $bottle){
        
        if (!Auth::user()->role_id == 1) {
            return redirect()->route('bottle.index')->with('error', 'Vous n\'avez pas les droits pour modifier cette bouteille.');
        }

        //TODO: Vérifier si la bouteille existe déjà dans le cellier
        // Sinon, on l'ajoute à la table cellar_bottle
        // Augmenter la quantité de bouteilles dans le cellier sélectionné
        // La quantité est ajoutée à la table cellar_bottle
        $request->validate([
            'cellar_id' => 'required|exists:cellars,id',
            'quantity' => 'required|integer|min:1'
        ]);
        $bottleInCellar = CellarBottle::create([
            'quantity' => $request->quantity,
            'bottle_id' => $bottle->id,
        ]);

        $cellarId = $request->cellar_id;
        //Ajouter le cellier sélectionné à la table cellar_bottles_has_cellars
        $bottleInCellar->cellars()->attach($cellarId);

        return redirect()->route('cellar.show', $cellarId)->with('success', 'La bouteille a été ajouté au cellier avec succès.');       
    }
}
