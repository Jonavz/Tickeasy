<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Section;
use App\Models\Seat;

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
            'max_capacity' => 'required|numeric|min:1',
            'sections' => 'required|array|min:1',
            'sections.*.name' => 'required|string|max:255',
            'sections.*.price' => 'required|numeric|min:0',
            'sections.*.quantity' => 'required|integer|min:1',
        ]);

        // Crear el lugar
        $place = Place::create([
            'name' => $request->name,
            'location' => $request->location,
            'max_capacity' => $request->max_capacity,
        ]);

        // Crear las secciones y asientos
        foreach ($request->sections as $sectionData) {
            $section = new Section();
            $section->place_id = $place->id;
            $section->name = $sectionData['name'];
            $section->price = $sectionData['price'];
            $section->save();

            // Solo crear asientos si el section_id ya fue generado
            if ($section->id) {
                for ($i = 1; $i <= $sectionData['quantity']; $i++) {
                    Seat::create([
                        'section_id' => $section->id,
                        'seat_number' => strtoupper($section->name) . $i,
                        'is_taken' => false,
                    ]);
                }
            }
        }

        return redirect()->route('places.index')->with('success', 'Lugar y secciones creados correctamente.');
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

        $place->update([
            'name' => $request->name,
            'location' => $request->location,
            'max_capacity' => $request->max_capacity,
        ]);

        return redirect()->route('places.index')->with('success', 'Ubicación actualizada correctamente.');
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return redirect()->route('places.index')->with('success', 'Lugar eliminado correctamente.');
    }
}
