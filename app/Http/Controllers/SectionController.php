<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Section;
use App\Models\Place;

class SectionController extends Controller
{
    public function create()
    {
        $places = \App\Models\Place::all();
        return view('sections.create', compact('places'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'place_id' => 'required|exists:places,id',
            'name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
        ]);

        Section::create($request->all());

        return redirect()->route('places.index')->with('success', 'Sección creada correctamente.');
    }
}
