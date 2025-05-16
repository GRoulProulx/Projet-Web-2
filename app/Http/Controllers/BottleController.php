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
        $query = Bottle::query();

        // Filtres
        if (request('country')) {
            $query->where('country', request('country'));
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        if (request('min_price') !== null) {
            $query->where('price', '>=', request('min_price'));
        }

        if (request('max_price') !== null) {
            $query->where('price', '<=', request('max_price'));
        }

        // Tri
        switch (request('sort_by')) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'country_asc':
                $query->orderBy('country', 'asc');
                break;
            case 'country_desc':
                $query->orderBy('country', 'desc');
                break;
            case 'type_asc':
                $query->orderBy('type', 'asc');
                break;
            case 'type_desc':
                $query->orderBy('type', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('name');
        }

        $bottles = $query->paginate(10);

        // Valeurs uniques pour les filtres
        $allCountries = Bottle::select('country')->distinct()->orderBy('country')->pluck('country');
        $allTypes = Bottle::select('type')->distinct()->orderBy('type')->pluck('type');

        return view('bottle.index', compact('bottles', 'allCountries', 'allTypes'));
    }

    /**
     * Afficher le formulaire pour créer une bouteille.
     */
    public function create()
    {
        if (!Auth::user()->role_id == 1) {
            abort(403, 'Vous n\'avez pas les droits pour accéder à cette page.');
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
}
