<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Place;

class EventController extends Controller
{
    public function index()
{
    $events = Event::with(['place', 'category'])->get(); 
    return view('events.index', compact('events'));
}


    public function public(Request $request)
    {
        $query = Event::query();


        if ($request->has('category')) {
            $categoryParam = $request->input('category');

            if (is_numeric($categoryParam)) {
                $query->where('category_id', $categoryParam);
            } else {
                $category = Category::where('name', 'LIKE', $categoryParam)->first();
                if ($category) {
                    $query->where('category_id', $category->id);
                } else {
                    $query->whereRaw('0 = 1');
                }
            }
        }


        $events = $query->get();
        return view('events.public', compact('events'));

    }



    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }



    public function create() {
        if (auth()->user()->role != 1) {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }

        $categories = Category::all();
        $places = Place::all();
        return view('events.create', compact('categories', 'places'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'place_id' => 'required|exists:places,id',
            'fecha_de_inicio' => 'required|date',
            'fecha_finalizacion' => 'required|date|after_or_equal:fecha_de_inicio',
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $event = new Event([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'place_id' => $request->place_id,
            'fecha_de_inicio' => $request->fecha_de_inicio,
            'fecha_finalizacion' => $request->fecha_finalizacion
        ]);

        if ($request->hasFile('logo_image')) {
            $logoPath = $request->file('logo_image')->store('event_logos', 'public');
            $event->logo_image = $logoPath;
        }

        $event->save();

        return redirect()->route('events.index')->with('success', 'Evento creado exitosamente.');
    }


public function edit(Event $event)
{
    if (auth()->user()->role != 1) {
        abort(403, 'No tienes permisos para acceder a esta página.');
    }

    $categories = Category::all();
    $places = Place::all();

    return view('events.edit', compact('event', 'categories', 'places'));
}


public function update(Request $request, Event $event)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'place_id' => 'required|exists:places,id',
        'fecha_de_inicio' => 'required|date',
        'fecha_finalizacion' => 'required|date|after_or_equal:fecha_de_inicio',
        'logo_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $event->update($request->except('logo_image'));

    if ($request->hasFile('logo_image')) {
        $file = $request->file('logo_image');
        $path = $file->store('public/event_logos');
        $event->logo_image = str_replace('public/', 'storage/', $path);
        $event->save();
    }

    return redirect()->route('events.index')->with('success', 'Evento actualizado.');
}
    public function destroy(Event $event)
    {
        if (auth()->user()->role != 1) {
            abort(403, 'No tienes permisos para eliminar este evento.');
        }

        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento eliminado.');
    }
}

