@extends('layouts.app')

@section('content')
<x-navbar />

<div class="crud-container">
    <h1>{{ $event->title }}</h1>

    <div class="event-details">
        <img src="{{ asset('storage/' . $event->logo_image) }}" alt="Imagen de {{ $event->title }}" class="event-image">

        <p><strong>Descripción:</strong> {{ $event->description }}</p>
        <p><strong>Categoría:</strong> {{ $event->category->name }}</p>
        <p><strong>Ubicación:</strong> {{ $event->place->name }}</p>
        <p><strong>Boletos Disponibles:</strong> {{ $event->available_tickets ?? 'Información no disponible' }}</p>
        <p><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($event->fecha_de_inicio)->format('d/m/y') }}</p>
        <p><strong>Precio:</strong> ${{ number_format($event->price, 2) }}</p>

        <!-- Formulario para comprar boletos -->
        @auth
            <form action="{{ route('cart.add', $event->id) }}" method="POST">
                @csrf
                <label for="quantity">Selecciona la cantidad de boletos:</label>
                <input type="number" name="quantity" min="1" max="{{ $event->available_tickets ?? 0 }}" required>
                <button type="submit">Añadir al Carrito</button>
            </form>
        @else
            <p><a href="{{ route('login') }}">Inicia sesión</a> para comprar boletos.</p>
        @endauth
    </div>
</div>
@endsection
