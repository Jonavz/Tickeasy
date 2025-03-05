<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $quantity = $request->quantity;

        if ($quantity > $event->available_tickets) {
            return back()->with('error', 'No hay suficientes boletos disponibles.');
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$eventId])) {
            $cart[$eventId]['quantity'] += $quantity;
        } else {
            $cart[$eventId] = [
                'title' => $event->title,
                'price' => $event->price,
                'quantity' => $quantity,
                'date' => $event->fecha_de_inicio 
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Boletos añadidos al carrito.');
    }

    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function remove($eventId)
    {
        $cart = Session::get('cart', []);
        unset($cart[$eventId]);
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Boletos eliminados del carrito.');
    }

    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado.');
    }


    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }

        foreach ($cart as $eventId => $details) {
            $event = Event::findOrFail($eventId);

            if ($details['quantity'] > $event->available_tickets) {
                return redirect()->route('cart.index')->with('error', 'No hay suficientes boletos disponibles para ' . $event->title);
            }

            // Reducir la cantidad de boletos disponible

            $event->place->max_capacity -= $details['quantity'];
            $event->place->save();



            Ticket::create([
                'user_id' => Auth::id(),
                'event_id' => $eventId,
                'quantity' => $details['quantity'],
                'amount_paid' => $details['price'] * $details['quantity'],
                'status' => 'Activo'
            ]);
        }

        // Vaciar el carrito
        Session::forget('cart');

        return redirect()->route('tickets.index')->with('success', 'Compra realizada con éxito. Tus boletos han sido generados.');
    }
}
