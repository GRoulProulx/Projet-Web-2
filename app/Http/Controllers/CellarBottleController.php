<?php

namespace App\Http\Controllers; 

use App\Models\CellarBottle;
use Illuminate\Http\Request;
use App\Models\Bottle;
use App\Models\Cellar;
class CellarBottleController extends Controller
{
    /**
     * Afficher le formulaire pour ajouter une nouvelle bouteille au cellier.
     */
    public function create()
    {
        $bottles = Bottle::all();
        // Afficher le formulaire pour ajouter une nouvelle bouteille au cellier
        return view('cellar_bottle.create', compact('bottles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'vintage' => 'nullable|integer',
            'bottle_id' => 'required|exists:bottles,id',
            'cellar_id' => 'required|exists:cellars,id'
        ]);
            $existingBottle = CellarBottle::whereHas('cellars', function ($query) use ($request) {
            $query->where('cellar_id', $request->cellar_id);
        })->where('bottle_id', $request->bottle_id)->first();

        if ($existingBottle) {
            $existingBottle->update([
            'quantity' => $existingBottle->quantity + $request->quantity,
            'purchase_date' => $request->purchase_date,
            'storage_until' => $request->storage_until,
            'notes' => $request->notes,
            'price' => $request->price,
            'vintage' => $request->vintage
            ]);
             $cellarBottle = $existingBottle;
    
        } else {
            $cellarBottle = CellarBottle::create([
            'purchase_date' => $request->purchase_date,
            'storage_until' => $request->storage_until,
            'notes' => $request->notes,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'vintage' => $request->vintage,
            'bottle_id' => $request->bottle_id,
            'cellar_id' => $request->cellar_id,
        ]);
        
        // Associer au cellier
        
      //  dd('Étape 5: Nouvelle bouteille ajoutée au cellier', $cellarBottle);
      
    }

    // Étape 6 - Redirection finale
    return redirect()
        ->route('cellar.show', $cellarBottle->cellar_id)
        ->with('success', 'Bouteille ajoutée au cellier avec succès.');
    }
    /**
     * Afficher les détails d'une bouteille spécifique dans le cellier.
     */
    public function show(CellarBottle $cellarBottle)
    {
        $cellars = Cellar::where('user_id', auth()->id())->with('cellarBottles')->get();
        $cellarId = $cellarBottle->cellar_id;
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
                'purchase_date' => 'nullable|date',
                'storage_until' => 'nullable|date',
                'notes' => 'nullable|string|max:191',
                'price' => 'nullable|decimal:2',
                'quantity' => 'required|integer|min:1',
                'vintage' => 'nullable|integer',
                'bottle_id' => 'required|exists:bottles,id',
                'cellar_id' => 'required|exists:cellars,id',
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
            'bottle_id' => $request->bottle_id,
            'cellar_id' => $request->cellar_id,
        ]);

        //Rediriger vers la liste des bouteilles dans le cellier
        return redirect()->route('cellar_bottle.show', $cellarBottle->id)->with('success', 'Bouteille mise à jour avec succès.');
    }

    /**
     * Supprimer une bouteille du cellier.
     */
    public function destroy(CellarBottle $cellarBottle)
    {
        $cellarId = $cellarBottle->cellar_id;
        $cellarBottle->delete();
        return redirect()->route('cellar.show', $cellarId )->with('success', 'Bouteille supprimée du cellier avec succès.');
    }

    /**
     * Marquer une bouteille comme bue.
     */
    public function drink(CellarBottle $cellarBottle)
    {
        $cellarBottle->update(['quantity' => $cellarBottle->quantity - 1]);
        return redirect()->route('cellar.show', $cellarBottle->cellar_id)->with('success', 'Bouteille marquée comme bue.');
    }
}
