<?php

namespace App\Http\Controllers;

use App\Models\Cellar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
class CellarController extends Controller
{
    /**
     * Affiche la liste des celliers appartenant à l'utilisateur connecté.
     *
     * @return \Illuminate\View\View La vue contenant la liste des celliers.
     */
    public function index()
    {
        $cellars = Cellar::where('user_id', auth()->id())->get();
        return view('cellar.index', compact('cellars'));
    }

    /**
     * Affiche le formulaire permettant à l'utilisateur de créer un nouveau cellier.
     *
     * @return \Illuminate\View\View La vue du formulaire de création de cellier.
     */
    public function create()
    {
        return view('cellar.create');
    }

    /**
     * Valide les données du formulaire et crée un nouveau cellier pour l'utilisateur connecté.
     *
     * @param \Illuminate\Http\Request $request Les données du formulaire de création.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page du cellier créé avec un message de succès.
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
     * Affiche les détails d'un cellier spécifique appartenant à l'utilisateur connecté.
     * Renvoie une erreur 403 si l'utilisateur n'est pas autorisé à accéder au cellier.
     *
     * @param \App\Models\Cellar $cellar Le cellier à afficher.
     * @return \Illuminate\View\View La vue contenant les détails du cellier.
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
     * Affiche le formulaire permettant de modifier un cellier spécifique appartenant à l'utilisateur connecté.
     * Renvoie une erreur 403 si l'utilisateur n'est pas autorisé à accéder au cellier.
     *
     * @param \App\Models\Cellar $cellar Le cellier à modifier.
     * @return \Illuminate\View\View La vue du formulaire de modification du cellier.
     */
    public function edit(Cellar $cellar)
    {
        if ($cellar->user_id !== Auth::user()->id) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à ce cellier.');
        }
        return view('cellar.edit', compact('cellar'));
    }

    /**
     * Valide les données du formulaire et met à jour un cellier spécifique appartenant à l'utilisateur connecté.
     *
     * @param \Illuminate\Http\Request $request Les données du formulaire de modification.
     * @param \App\Models\Cellar $cellar Le cellier à mettre à jour.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la page du cellier modifié avec un message de succès.
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
     * Supprime un cellier spécifique appartenant à l'utilisateur connecté.
     *
     * @param \App\Models\Cellar $cellar Le cellier à supprimer.
     * @return \Illuminate\Http\RedirectResponse Redirige vers la liste des celliers avec un message de succès.
     */
    public function destroy(Cellar $cellar)
    {
        // Supprimer le cellier
        $cellar->delete();

        // Rediriger vers la liste des celliers
        return redirect()->route('cellar.index')->with('success', 'Cellier supprimé avec succès !');
    }

    /**
     * Fontion de deplacement des bouteilles  entre celliers de l'usager 
     * Valide les données provenant du cellier et fait la mise à jour
     * après le deplacement 
     */

    public function moveBottle(Request $request)
    {
        $validated = $request->validate([
            'bottle_id' => 'required|exists:bottles,id',
            'from_cellar_id' => 'required|exists:cellars,id',
            'to_cellar_id' => 'required|exists:cellars,id|different:from_cellar_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $from = DB::table('cellar_bottles')
            ->where('cellar_id', $validated['from_cellar_id'])
            ->where('bottle_id', $validated['bottle_id'])
            ->first();

        if (!$from || $from->quantity < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Quantité insuffisante dans le cellier de départ.']);
        }

    // Retirer la quantité du cellier source
        DB::table('cellar_bottles')
            ->where('cellar_id', $validated['from_cellar_id'])
            ->where('bottle_id', $validated['bottle_id'])
            ->decrement('quantity', $validated['quantity']);

    // Ajouter la quantité au cellier de  destination
        $existing = DB::table('cellar_bottles')
            ->where('cellar_id', $validated['to_cellar_id'])
            ->where('bottle_id', $validated['bottle_id'])
            ->first();

        if ($existing) {
            DB::table('cellar_bottles')
            ->where('cellar_id', $validated['to_cellar_id'])
            ->where('bottle_id', $validated['bottle_id'])
            ->increment('quantity', $validated['quantity']);
        } else {
            DB::table('cellar_bottles')->insert([
                'cellar_id' => $validated['to_cellar_id'],
                'bottle_id' => $validated['bottle_id'],
                'quantity' => $validated['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Bouteille déplacée avec succès.');
    }

}
