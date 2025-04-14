@extends('layouts.app')

@section('content')
<x-navbar />

<style>
    body {
        font-family: 'Lato', sans-serif;
    }

    .card {
        background-color: #0f1d3f;
        color: white;
        border: 1px solid #1E293B;
    }

    .card .card-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #ffffff;
    }

    .card .card-text {
        font-size: 0.95rem;
        color: #b0b8c1;
    }

    .btn-sm {
        padding: 5px 12px;
        font-size: 0.85rem;
    }

    .btn-warning {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background-color: #d97706;
    }

    .btn-danger {
        background-color: #ef4444;
        border-color: #ef4444;
    }

    .btn-danger:hover {
        background-color: #dc2626;
    }

    .btn-success {
        background-color: #22c55e;
        border-color: #22c55e;
    }

    .btn-success:hover {
        background-color: #16a34a;
    }

    .admin-title {
        color: white;
        font-family: 'Lato', sans-serif;
        font-weight: 800;
    }

    .text-muted {
        color: #94a3b8 !important;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-center admin-title"> Gestión de Eventos</h2>

    <div class="text-end mb-4">
        <a href="{{ route('events.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Crear Nuevo Evento
        </a>
    </div>

    <div class="row">
        @forelse ($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 border-0">
                    @if ($event->logo_image)
                        <img src="{{ asset('storage/' . $event->logo_image) }}" class="card-img-top rounded-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($event->description, 80) }}</p>
                        <p class="text-muted mb-1"><i class="bi bi-geo-alt-fill"></i> {{ $event->place->name ?? 'Sin lugar asignado' }}</p>
                        <p class="text-muted mb-3"><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($event->fecha_de_inicio)->format('d/m/Y') }}</p>

                        <div class="d-flex justify-content-between mt-auto pt-3">
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-fill"></i> Editar
                            </a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este evento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash3-fill"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center mt-4">
                <p class="text-muted fs-5">No hay eventos registrados actualmente.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
