<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\Seat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];

        foreach ($cart as $eventId => $details) {
            $seats = Seat::with('section')->whereIn('id', $details['seats'])->get();

            foreach ($seats as $seat) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => "Asiento " . $seat->seat_number . " - " . $seat->section->name . " (" . $seat->section->place->name . ")",
                        ],
                        'unit_amount' => intval($seat->section->price * 100),
                    ],
                    'quantity' => 1,
                ];
            }
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('cart.index'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }

        foreach ($cart as $eventId => $details) {
            $seats = Seat::with('section')->whereIn('id', $details['seats'])->where('is_taken', false)->get();

            if ($seats->count() != count($details['seats'])) {
                return redirect()->route('cart.index')->with('error', 'Algunos asientos ya no están disponibles.');
            }

            foreach ($seats as $seat) {
                $seat->is_taken = true;
                $seat->save();
            }

            Ticket::create([
                'user_id' => Auth::id(),
                'event_id' => $eventId,
                'quantity' => $seats->count(),
                'amount_paid' => $seats->sum(fn($s) => $s->section->price),
                'status' => 'Activo'
            ]);
        }

        Session::forget('cart');

        return redirect()->route('tickets.index')->with('success', 'Pago realizado con éxito. Tus boletos han sido generados.');
    }
}
