<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use App\Models\Cellar;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CellarBottle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BottleController extends Controller
{
    /**
     * Afficher la liste des bouteilles.
     */
    
    public function index()
    {
        $query = Bottle::query()
            ->where(function ($q) {
            $q->where('is_custom', false)->orWhereNull('is_custom');
        });

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

        $bottles = $query->paginate(12);

        // Filtres dynamiques (sur les bouteilles non personnalisées seulement)
        $allCountries = Bottle::where(function ($q) {
            $q->where('is_custom', false)->orWhereNull('is_custom');
        })
            ->select('country')->distinct()->orderBy('country')->pluck('country');

            $allTypes = Bottle::where(function ($q) {
            $q->where('is_custom', false)->orWhereNull('is_custom');
        })
            ->select('type')->distinct()->orderBy('type')->pluck('type');

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
    /**
     * Créer une bouteille personalisée
     */

    public function createCustom()
    {
        $cellars = auth()->user()->cellars;

        return view('bottle.create-custom', compact('cellars'));
    }

    public function storeCustom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'price' => 'nullable|numeric|min:0',
            'type' => 'nullable|string',
            'format' => 'nullable|string',
            'country' => 'nullable|string',
            'description' => 'nullable|string',
            'cellar_id' => 'required|exists:cellars,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Traitement de l'image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('bottles', 'public');
            $imagePath = 'storage/' . $path;
        } else {
            $imagePath = 'images/bouteille-par-defaut.jpg';
        }

        $bottle = Bottle::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'image' =>  $imagePath,
            'price' => $request->price,
            'type' => $request->type,
            'format' => $request->format,
            'country' => $request->country,
            'description' => $request->description,
            'is_custom' => true,
        ]);

    // Ajouter dans le cellier
        DB::table('cellar_bottles')->insert([
            'cellar_id' => $request->cellar_id,
            'bottle_id' => $bottle->id,
            'quantity' => $request->quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('cellar.show', $request->cellar_id)
        ->with('success', 'Bouteille personnalisée ajoutée à votre cellier.');
    }
    public function search(Request $request)
    {
        if ($request->filled('search')) {
            $bottles = Bottle::search($request->search)->paginate(10);
        } else {
            $bottles = Bottle::paginate(10);
        }

        $allCountries = Bottle::where(function ($q) {
            $q->where('is_custom', false)->orWhereNull('is_custom');
        })
            ->select('country')->distinct()->orderBy('country')->pluck('country');

        $allTypes = Bottle::where(function ($q) {
            $q->where('is_custom', false)->orWhereNull('is_custom');
        })
            ->select('type')->distinct()->orderBy('type')->pluck('type');

        return view('bottle.index', compact('bottles', 'allCountries', 'allTypes'));
    }
    public function searchInCellar(Request $request, $cellar_id)
    {
        // Récupération du cellier spécifié
        $cellar = Cellar::findOrFail($cellar_id);

        if ($request->filled('search')) {
            $bottleIds = CellarBottle::where('cellar_id', $cellar_id)->pluck('bottle_id');
            $bottles = Bottle::search($request->search)
                ->whereIn('id', $bottleIds)
                ->get();

            // Cercher les bouteilles du cellier
            $cellarBottles = collect();
            foreach ($bottles as $bottle) {
                $cellarBottle = CellarBottle::where('cellar_id', $cellar_id)
                    ->where('bottle_id', $bottle->id)
                    ->first();

                if ($cellarBottle) {
                    // Ajout de la bouteille à l'objet cellarBottle pour la vue
                    $cellarBottle->bottle = $bottle;
                    $cellarBottles->push($cellarBottle);
                }
            }
        } else {
            // Récupération de toutes les bouteilles dans ce cellier
            $cellarBottles = CellarBottle::where('cellar_id', $cellar_id)
                ->with('bottle')
                ->paginate(10);
        }

        
        $allCountries = Bottle::where(function ($q) {
            $q->where('is_custom', false)->orWhereNull('is_custom');
        })
            ->select('country')->distinct()->orderBy('country')->pluck('country');

        // Récupération de tous les types de vin disponibles (hors bouteilles personnalisées)
        $allTypes = Bottle::where(function ($q) {
            $q->where('is_custom', false)->orWhereNull('is_custom');
        })
            ->select('type')->distinct()->orderBy('type')->pluck('type');

        
        return view('cellar.show', compact('cellar', 'cellarBottles', 'allCountries', 'allTypes'));
    }
}
