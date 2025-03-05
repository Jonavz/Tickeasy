<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Ticket;
use App\Models\Event;
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
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $details['title'],
                    ],
                    'unit_amount' => $details['price'] * 100,
                ],
                'quantity' => $details['quantity'],
            ];
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
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
            $event = Event::findOrFail($eventId);

            // Verificar disponibilidad de boletos
            if ($details['quantity'] > $event->available_tickets) {
                return redirect()->route('cart.index')->with('error', 'No hay suficientes boletos disponibles.');
            }

            // Reducir boletos disponibles
            $event->place->max_capacity -= $details['quantity'];
            $event->place->save();

            // Generar boleto
            Ticket::create([
                'user_id' => Auth::id(),
                'event_id' => $eventId,
                'quantity' => $details['quantity'],
                'amount_paid' => $details['price'] * $details['quantity'],
                'status' => 'Activo'
            ]);
        }

        // Limpiar carrito
        Session::forget('cart');

        return redirect()->route('tickets.index')->with('success', 'Pago realizado con éxito. Tus boletos han sido generados.');
    }
}
