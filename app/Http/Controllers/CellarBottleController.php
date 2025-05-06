<?php

namespace App\Http\Controllers; 

use App\Models\CellarBottle;
use Illuminate\Http\Request;
use App\Models\Bottle;
use App\Models\Cellar;
class CellarBottleController extends Controller
{
    /**
     * Afficher la liste des bouteilles dans un cellier.
     */
  /*   public function index($cellarId)
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
    } */

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
    // Étape 1 - Validation
    //dd('Étape 1: Début de la méthode');
    //dd('Contenu de la requête', $request->all());

    $request->validate([
        //'purchase_date' => 'required|date',
       // 'storage_until' => 'required|date',
        //'notes' => 'nullable|string|max:191',
        //'price' => 'required|numeric|decimal:2',
        'quantity' => 'required|integer|min:1',
        'vintage' => 'nullable|integer',
        'bottle_id' => 'required|exists:bottles,id',
        'cellar_id' => 'required|exists:cellars,id'
    ]);

        //dd('Étape 2: Validation réussie', $request->all());

        // Étape 3 - Rechercher une bouteille existante dans ce cellier
        $existingBottle = CellarBottle::whereHas('cellars', function ($query) use ($request) {
        $query->where('cellar_id', $request->cellar_id);
    })->where('bottle_id', $request->bottle_id)->first();
    //dd('Étape 3: Bouteille existante ?', $existingBottle);
    

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
      //  dd('Étape 4: Quantité mise à jour', $cellarBottle);
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
        ->route('cellar_bottle.show', $cellarBottle->id)
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
                'purchase_date' => 'required|date',
                'storage_until' => 'required|date',
                'notes' => 'nullable|string|max:191',
                'price' => 'required|decimal:2',
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
        return redirect()->route('cellar_bottle.show', $cellarBottle->id)->with('success', 'Bouteille marquée comme bue.');
    }
}
