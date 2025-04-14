@extends('layouts.app')

@section('content')
<x-navbar />

<div class="container py-5">
    <h2 class="mb-4 text-center">Eventos Disponibles</h2>

    <div class="row">
        @forelse ($events as $event)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                @if ($event->logo_image)
                    <img src="{{ asset('storage/' . $event->logo_image) }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="card-text text-white">{{ \Illuminate\Support\Str::limit($event->description, 80) }}</p>
                    <p class="mb-1 text-white"><i class="bi bi-geo-alt-fill"></i> {{ $event->place->name ?? 'Ubicación no disponible' }}</p>
                    <p class="text-white mb-2"><i class="bi bi-calendar"></i> {{ $event->fecha_de_inicio }}</p>

                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-primary mt-auto">
                        <i class="bi bi-eye"></i> Ver Detalles
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">No hay eventos disponibles en este momento.</p>
        </div>
        @endforelse
    </div>
</div>
<x-footer />
@endsection
