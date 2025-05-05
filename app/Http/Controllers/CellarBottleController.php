<?php

namespace App\Http\Controllers; 

use App\Models\CellarBottle;
use Illuminate\Http\Request;
use App\Models\Cellar;
use App\Models\Bottle;

class CellarBottleController extends Controller
{
    /**
     * Afficher la liste des bouteilles dans un cellier.
     */
    public function index($cellarId)
    {
        // $cellarId = request()->segment(2);
        // return $cellarId;
        $cellars = Cellar::where('user_id', auth()->id())->with('cellarBottles')->get();
        $cellar = $cellars->find($cellarId);
        $cellarBottles = $cellars->flatMap(function ($cellar) {
            return $cellar->cellarBottles;
        });
        return view('cellar_bottle.index', [
            'cellarBottles' => $cellarBottles,
            'cellars' => $cellars,
            'cellar' => $cellar
        ]);  
    }

    /**
     * Afficher le formulaire pour ajouter une nouvelle bouteille au cellier.
     */
    public function create()
    {  
        $bottles = Bottle::all();
        // Afficher le formulaire pour ajouter une nouvelle bouteille au cellier
        return view('cellar_bottle.create', compact('bottles'));
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
        return redirect()->route('cellar_bottle.show', $cellarBottle->id)->with('success', 'Bouteille mise à jour avec succès.');
    }

    /**
     * Afficher les détails d'une bouteille spécifique dans le cellier.
     */
    public function show(CellarBottle $cellarBottle)
    {
        $cellars = Cellar::where('user_id', auth()->id())->with('cellarBottles')->get();
        $cellarId = $cellarBottle->cellars->first()->pivot->cellar_id;
        return view('cellar_bottle.show', ['cellarBottle' => $cellarBottle, 'cellar' => $cellars, 'cellarId' => $cellarId]);
    }

    /**
     * Afficher le formulaire pour modifier une bouteille dans le cellier.
     */
    public function edit(CellarBottle $cellarBottle)
    {
        $cellars = Cellar::where('user_id', auth()->id())->with('cellarBottles')->get();
        return view('cellar_bottle.edit', ['cellarBottle' => $cellarBottle, 'cellars' => $cellars]);
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

        //Mettre à jour le cellier de la bouteille dans la table cellar_bottles_has_cellars
        $cellarBottle->cellars()->update([
            'cellar_id' => $request->cellar_id
        ]);        

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
        return redirect()->route('cellar_bottle.show', $cellarBottle->id)->with('success', 'Bouteille mise à jour avec succès.');
    }

    /**
     * Supprimer une bouteille du cellier.
     */
    public function destroy(CellarBottle $cellarBottle)
    {
        $cellarId = $cellarBottle->cellars->first()->pivot->cellar_id;
        $cellarBottle->delete();
        return redirect()->route('cellar.show', $cellarId )->with('success', 'Bouteille supprimée du cellier avec succès.');
    }

    /**
     * Marquer une bouteille comme bue.
     */
    public function drink(CellarBottle $cellarBottle)
    {
        $cellarBottle->update(['quantity' => $cellarBottle->quantity - 1]);
        return redirect()->route('cellar_bottle.show', $cellarBottle->id)->with('success', 'Bouteille marquée comme bue.');
    }
}
