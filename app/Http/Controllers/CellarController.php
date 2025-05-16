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
                'name' => 'required|string|max:20'
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
        $sortBy = request('sort_by', 'name');
        $order = request('order', 'asc');

        $validSorts = ['name', 'price', 'purchase_date'];
        if (!in_array($sortBy, $validSorts)) {
            $sortBy = 'name';
        }

    // Récupération des cellarBottles triées
         $cellarBottles = $cellar->cellarBottles()
            ->with('bottle')
            ->when(in_array($sortBy, ['name', 'price']), function ($query) use ($sortBy, $order) {
            $query->join('bottles', 'cellar_bottles.bottle_id', '=', 'bottles.id')
                ->orderBy("bottles.$sortBy", $order)
                ->select('cellar_bottles.*');
        })
            ->when($sortBy === 'purchase_date', function ($query) use ($order) {
            $query->orderBy('purchase_date', $order);
        })
            ->get();

    return view('cellar.show', compact('cellar', 'cellarBottles'));
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
                'name' => 'required|string|max:12'
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
