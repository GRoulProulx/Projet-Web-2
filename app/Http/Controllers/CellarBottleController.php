<?php

namespace App\Http\Controllers; 

use App\Models\CellarBottle;
use Illuminate\Http\Request;
use App\Models\Bottle;
use App\Models\Cellar;
class CellarBottleController extends Controller
{
    /**
     * Affiche le formulaire permettant d'ajouter une nouvelle bouteille à un cellier.
     *
     * @return \Illuminate\View\View La vue du formulaire de création de bouteille dans un cellier.
     */
    public function create()
    {
        $bottles = Bottle::all();
        // Afficher le formulaire pour ajouter une nouvelle bouteille au cellier
        return view('cellar_bottle.create', compact('bottles'));
    }

    /**
     * Valide les données du formulaire et ajoute une nouvelle bouteille au cellier.
     * Si la bouteille existe déjà dans le cellier, met à jour sa quantité et ses informations.
     *
     * @param \Illuminate\Http\Request $request Les données du formulaire de création.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page du cellier avec un message de succès.
     */
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
    }

    // Étape 6 - Redirection finale
    return redirect()
        ->route('cellar.show', $cellarBottle->cellar_id)
        ->with('success', 'Bouteille ajoutée au cellier avec succès.');
    }

    /**
     * Affiche les détails d'une bouteille spécifique dans un cellier.
     * Vérifie que la bouteille appartient bien à un cellier de l'utilisateur connecté.
     *
     * @param \App\Models\CellarBottle $cellarBottle La bouteille à afficher.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse La vue des détails de la bouteille ou une redirection en cas d'erreur.
     */
    public function show(CellarBottle $cellarBottle)
    {
        if (!auth()->user()->cellars->contains('id', $cellarBottle->cellar_id)) {
            return redirect()->route('cellar.index')->withErrors('Cette bouteille n\'est pas dans votre cellier.');
        }
        $cellars = Cellar::where('user_id', auth()->id())->with('cellarBottles')->get();
        $cellarId = $cellarBottle->cellar_id;
        return view('cellar_bottle.show', ['cellarBottle' => $cellarBottle, 'cellar' => $cellars, 'cellarId' => $cellarId]);
    }

    /**
     * Affiche le formulaire permettant de modifier une bouteille dans un cellier.
     * Vérifie que la bouteille appartient bien à un cellier de l'utilisateur connecté.
     *
     * @param \App\Models\CellarBottle $cellarBottle La bouteille à modifier.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse La vue du formulaire de modification ou une redirection en cas d'erreur.
     */
    public function edit(CellarBottle $cellarBottle)
    {
        if (!auth()->user()->cellars->contains('id', $cellarBottle->cellar_id)) {
            return redirect()->route('cellar.index')->withErrors('Cette bouteille n\'est pas dans votre cellier.');
        }
        $cellars = Cellar::where('user_id', auth()->id())->with('cellarBottles')->get();
        return view('cellar_bottle.edit', ['cellarBottle' => $cellarBottle, 'cellars' => $cellars]);
    }

    /**
     * Valide les données du formulaire et met à jour une bouteille dans un cellier.
     *
     * @param \Illuminate\Http\Request $request Les données du formulaire de modification.
     * @param \App\Models\CellarBottle $cellarBottle La bouteille à mettre à jour.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page des détails de la bouteille avec un message de succès.
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
     * Supprime une bouteille spécifique d'un cellier.
     *
     * @param \App\Models\CellarBottle $cellarBottle La bouteille à supprimer.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page du cellier avec un message de succès.
     */
    public function destroy(CellarBottle $cellarBottle)
    {
        $cellarId = $cellarBottle->cellar_id;
        $cellarBottle->delete();
        return redirect()->route('cellar.show', $cellarId )->with('success', 'Bouteille supprimée du cellier avec succès.');
    }

    /**
     * Réduit la quantité d'une bouteille dans un cellier de 1, marquant ainsi une bouteille comme bue.
     *
     * @param \App\Models\CellarBottle $cellarBottle La bouteille à mettre à jour.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page du cellier avec un message de succès.
     */
    public function drink(CellarBottle $cellarBottle)
    {
        $cellarBottle->update(['quantity' => $cellarBottle->quantity - 1]);
        return redirect()->route('cellar.show', $cellarBottle->cellar_id)->with('success', 'Bouteille marquée comme bue.');
    }
}
