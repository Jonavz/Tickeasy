@extends('layouts.app')

@section('content')
<x-navbar />

<div class="cart-container">
    <h1>Carrito de Boletos</h1>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif

    @if(count($cart) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($cart as $eventId => $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <tr>
                        <td>{{ $item['title'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($item['date'])->format('d/m/y') }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $eventId) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Total a Pagar: ${{ number_format($total, 2) }}</h2>

        <form action="{{ route('payment.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Pagar con Tarjeta</button>
        </form>

        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-warning">Vaciar Carrito</button>
        </form>
    @else
        <p>El carrito está vacío.</p>
    @endif
</div>
@endsection
