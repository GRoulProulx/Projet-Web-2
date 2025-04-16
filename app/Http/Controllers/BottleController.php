<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use Illuminate\Http\Request;

class BottleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bottle.index');
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
        //
    }

    /**
     * Afficher les détails d'une bouteille.
     */
    public function show(Bottle $bottle)
    {
        //
    }

    /**
     * Afficher le formulaire pour modifier une bouteille.
     */
    public function edit(Bottle $bottle)
    {
        
    }

    /**
     * Modifier une bouteille.
     */
    public function update(Request $request, Bottle $bottle)
    {
        //
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
