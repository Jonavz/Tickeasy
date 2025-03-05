@extends('layouts.app')

@section('content')
<x-navbar />

<div class="crud-container">
    <h1>Administrar Eventos</h1>

    <a href="{{ route('events.create') }}" class="btn btn-primary">Crear Nuevo Evento</a>

    <div class="event-grid">
        @foreach ($events as $event)
        <div class="event-card">
            <img src="{{ asset('storage/' . $event->logo_image) }}" alt="{{ $event->title }}" class="event-image">
            <div class="event-info">
                <p class="event-date">{{ \Carbon\Carbon::parse($event->fecha_de_inicio)->format('d/m/y') }}</p>
                <h2 class="event-title">{{ $event->title }}</h2>
                <p class="event-location">{{ $event->location }}</p>
                <p class="event-price"><strong>Desde ${{ number_format($event->price, 2) }}</strong></p>
                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
