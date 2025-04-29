<?php

namespace App\Http\Controllers;

use App\Models\CellarBottle;
use Illuminate\Http\Request;

class CellarBottleController extends Controller
{
    /**
     * Afficher la liste des bouteilles dans un cellier.
     */
    public function index()
    {
        $cellarBottles = CellarBottle::all();
        return view('cellar_bottle.index', compact('cellarBottles'));
    }

    /**
     * Afficher le formulaire pour ajouter une nouvelle bouteille au cellier.
     */
    public function create()
    {
        return view('cellar_bottle.create');
    }

    /**
     * Stocker une nouvelle bouteille dans le cellier.
     */
    public function store(Request $request)
    {
        //Valider les données du formulaire
        $request->validate(
            [
                'purchase_date' => 'required|date',
                'storage_until' => 'required|date',
                'notes' => 'nullable|string|max:191',
                'price' => 'required|decimal:2',
                'quantity' => 'required|integer|min:1',
                'vintage' => 'nullable|integer',
                'bottle_id' => 'required|exists:bottles,id'
            ]
        );

        //Créer la bouteille dans le cellier
        $cellarBottle = CellarBottle::create([
            'purchase_date' => $request->purchase_date,
            'storage_until' => $request->storage_until,
            'notes' => $request->notes,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'vintage' => $request->vintage,
            'bottle_id' => $request->bottle_id
        ]);

        //Rediriger vers la liste des bouteilles dans le cellier
        return redirect()->route('cellar_bottle.index')->with('success', 'Bouteille ajoutée au cellier avec succès.');
    }

    /**
     * Afficher les détails d'une bouteille spécifique dans le cellier.
     */
    public function show(CellarBottle $cellarBottle)
    {
        return view('cellar_bottle.show', ['cellarBottle' => $cellarBottle]);
    }

    /**
     * Afficher le formulaire pour modifier une bouteille dans le cellier.
     */
    public function edit(CellarBottle $cellarBottle)
    {
        return view('cellar_bottle.edit', ['cellarBottle' => $cellarBottle]);
    }

    /**
     * Modifier une bouteille dans le cellier.
     */
    public function update(Request $request, CellarBottle $cellarBottle)
    {
        //Valider les données du formulaire
        $request->validate(
            [
                'purchase_date' => 'required|date',
                'storage_until' => 'required|date',
                'notes' => 'nullable|string|max:191',
                'price' => 'required|decimal:2',
                'quantity' => 'required|integer|min:1',
                'vintage' => 'nullable|integer',
                'bottle_id' => 'required|exists:bottles,id'
            ]
        );

        //Mettre à jour la bouteille dans le cellier
        $cellarBottle->update([
            'purchase_date' => $request->purchase_date,
            'storage_until' => $request->storage_until,
            'notes' => $request->notes,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'vintage' => $request->vintage,
            'bottle_id' => $request->bottle_id
        ]);

        //Rediriger vers la liste des bouteilles dans le cellier
        return redirect()->route('cellar_bottle.index')->with('success', 'Bouteille mise à jour avec succès.');
    }

    /**
     * Supprimer une bouteille du cellier.
     */
    public function destroy(CellarBottle $cellarBottle)
    {
        $cellarBottle->delete();
        return redirect()->route('cellar_bottle.index')->with('success', 'Bouteille supprimée du cellier avec succès.');
    }
}
