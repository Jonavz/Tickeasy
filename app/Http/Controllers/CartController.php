<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Mostrar el carrito
    public function index()
    {
        $cart = Session::get('cart', []);
        $events = [];

        foreach ($cart as $eventId => $details) {
            $event = Event::find($eventId);
            if ($event) {
                $events[$eventId] = $event;
            } else {
                unset($cart[$eventId]);
                Session::put('cart', $cart);
            }
        }

        return view('cart.index', compact('cart', 'events'));
    }

    // Añadir boletos al carrito (por sección)
    public function add(Request $request, Event $event)
    {
        $sectionId = $request->input('section_id');
        $quantity = (int) $request->input('quantity');

        if (!$sectionId || $quantity < 1) {
            return back()->with('error', 'Debes seleccionar una sección y una cantidad válida.');
        }

        $section = $event->place->sections()->where('sections.id', $sectionId)->first();

        if (!$section) {
            return back()->with('error', 'La sección seleccionada no pertenece a este evento.');
        }

        $availableSeats = $section->seats()->where('is_taken', false)->take($quantity)->get();

        if ($availableSeats->count() != $quantity) {
            return back()->with('error', 'No hay suficientes asientos disponibles.');
        }

        $cart = Session::get('cart', []);

        $cart[$event->id] = [
            'seats' => $availableSeats->pluck('id')->toArray(),
            'quantity' => $quantity,
            'total' => $availableSeats->sum(fn($s) => $s->section->price),
            'title' => $event->title,
        ];

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Boletos añadidos al carrito.');
    }

    // Eliminar un evento del carrito
    public function remove($eventId)
    {
        $cart = Session::get('cart', []);
        unset($cart[$eventId]);
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Evento eliminado del carrito.');
    }

    // Vaciar carrito completo
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado.');
    }

    // Finalizar compra (marca asientos como ocupados y crea ticket)
    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }

        foreach ($cart as $eventId => $details) {
            $event = Event::find($eventId);

            if (!$event) continue;

            $seatIds = $details['seats'];
            $seats = Seat::with('section')->whereIn('id', $seatIds)->where('is_taken', false)->get();

            if ($seats->count() != count($seatIds)) {
                return redirect()->route('cart.index')->with('error', 'Uno o más asientos ya están ocupados.');
            }

            foreach ($seats as $seat) {
                $seat->is_taken = true;
                $seat->save();
            }

            Ticket::create([
                'user_id' => Auth::id(),
                'event_id' => $eventId,
                'quantity' => count($seats),
                'amount_paid' => $seats->sum(fn($s) => $s->section->price),
                'status' => 'Activo'
            ]);
        }

        Session::forget('cart');

        return redirect()->route('tickets.index')->with('success', 'Compra realizada con éxito. Tus boletos han sido generados.');
    }
}
