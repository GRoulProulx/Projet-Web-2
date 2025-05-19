<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomBottleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:50',
        'country' => 'nullable|string|max:100',
        'format' => 'nullable|string|max:20',
        'price' => 'nullable|numeric|min:0',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('custom_bottles', 'public');
        }

        CustomBottle::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'type' => $request->type,
            'country' => $request->country,
            'format' => $request->format,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Bouteille ajoutée avec succès.');
    }

}
