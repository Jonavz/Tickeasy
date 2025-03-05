<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::all();
        return view('places.index', compact('places'));
    }

    public function create()
    {
        return view('places.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'max_capacity' => 'required|integer|min:1'
        ]);

        Place::create([
            'name' => $request->name,
            'location' => $request->location,
            'max_capacity' => $request->max_capacity
        ]);

        return redirect()->route('places.index')->with('success', 'Ubicación agregada correctamente.');
    }


    public function edit(Place $place)
{
    return view('places.edit', compact('place'));
}

public function update(Request $request, Place $place)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'max_capacity' => 'required|integer|min:1'
    ]);

    $place->update($request->all());

    return redirect()->route('places.index')->with('success', 'Ubicación actualizada correctamente.');
}


    public function destroy(Place $place)
    {
        $place->delete();

        return redirect()->route('places.index')->with('success', 'Lugar eliminado correctamente.');
    }
}

