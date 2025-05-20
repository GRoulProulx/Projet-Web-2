<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bottle;
use App\Models\ShoppingList;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Récupérer la liste d'achat de l'utilisateur connecté
        $shoppingListItems = ShoppingList::where('user_id', Auth::id())
            ->with('bottle')
            ->get();

        return view('shopping_list.index', compact('shoppingListItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Bottle $bottle)
    {
        $request->validate([
            'quantity' => 'integer|min:1',
        ]);

        $existingItem = auth()->user()->shoppingList()
            ->where('bottle_id', $bottle->id)
            ->first();

        // Si la bouteille existe déjà, on ajoute la quantité demandée à la bouteille existante.
        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity
            ]);
        } else {
            auth()->user()->shoppingList()->create([
                'bottle_id' => $bottle->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Bouteille ajoutée à votre liste d\'achats.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingList $shoppingList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShoppingList $shoppingList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShoppingList $shoppingList)
    {
        $request->validate([
            'quantity' => 'integer|min:1',
        ]);

        $shoppingList->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->with('success', 'Quantité mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingList $shoppingList)
    {
        $shoppingList->delete();

        return redirect()->back()->with('success', 'Bouteille retirée de votre liste d\'achats.');
    }
}
