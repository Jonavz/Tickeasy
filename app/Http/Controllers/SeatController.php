<?php

namespace App\Http\Controllers;
use App\Models\Seat;
use App\Models\Section;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function create()
    {
        $sections = \App\Models\Section::all();
        return view('seats.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'seat_number' => 'required|string|max:10',
        ]);

        Seat::create([
            'section_id' => $request->section_id,
            'seat_number' => $request->seat_number,
        ]);

        return redirect()->back()->with('success', 'Asiento creado correctamente.');
    }
}
