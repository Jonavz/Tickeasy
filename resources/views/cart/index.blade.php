@extends('layouts.app')

@section('content')
<x-navbar />

<div class="container py-5 text-white" style="font-family: 'Lato', sans-serif;">
    <h2 class="text-center mb-5 fw-bold">Mi Carrito de Compras</h2>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if (!empty($cart) && count($cart) > 0)
        @foreach ($cart as $eventId => $details)
            @php
                $event = $events[$eventId] ?? null;
                $seats = \App\Models\Seat::with('section')->whereIn('id', $details['seats'])->get();
            @endphp

            @if ($event)
            <div class="card bg-dark text-white border-0 mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $event->title }}</h4>
                    <form action="{{ route('cart.remove', $eventId) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash-fill"></i> Quitar
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    <p class="mb-1"><i class="bi bi-calendar3"></i> {{ $event->fecha_de_inicio }} - {{ $event->fecha_finalizacion }}</p>
                    <p class="mb-3"><i class="bi bi-geo-alt-fill"></i> {{ $event->place->name ?? 'Ubicación no disponible' }}</p>

                    <h6>Asientos Seleccionados:</h6>
                    <ul class="list-group list-group-flush text-white">
                        @foreach ($seats as $seat)
                            <li class="list-group-item bg-transparent border-bottom border-light text-white">
                                {{ $seat->seat_number }} — {{ $seat->section->name }} (${{ number_format($seat->section->price, 2) }})
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-3 text-end">
                        <strong>Total:</strong> ${{ number_format($seats->sum(fn($s) => $s->section->price), 2) }}
                    </div>
                </div>
            </div>
            @endif
        @endforeach

        <div class="text-center mt-5">
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg px-5">
                    <i class="bi bi-credit-card-fill me-1"></i> Finalizar Compra
                </button>
            </form>
        </div>

    @else
        <div class="alert alert-warning text-center">
            Tu carrito está vacío. ¡Explora nuestros eventos y añade tus boletos favoritos!
        </div>
    @endif
</div>
<x-footer />

@endsection
