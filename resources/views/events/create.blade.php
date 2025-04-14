@extends('layouts.app')

@section('content')
<x-navbar />

<style>
    body {
        font-family: 'Lato', sans-serif;
    }

    .card {
        background-color: #121d35;
        border: 1px solid #213550;
        color: white;
        position: relative;
    }

    .card-header {
        background-color: #182446;
        font-family: 'Lato', sans-serif;
        color: white;
    }

    .btn-close {
        position: absolute;
        top: 12px;
        right: 16px;
        color: white;
        background: none;
        border: none;
        font-size: 1.4rem;
        line-height: 1;
        opacity: 0.8;
    }

    .btn-close:hover {
        opacity: 1;
        color: #f87171;
    }

    label {
        color: #d1d5db;
    }

    .form-control, .form-select {
        background-color: #1f2937;
        border-color: #374151;
        color: #f3f4f6;
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .form-text {
        color: #9ca3af;
    }

    .alert-danger {
        background-color: #7f1d1d;
        color: white;
        border: none;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg">
                <div class="card-header text-center">
                    <h3 class="mb-0">Crear Nuevo Evento</h3>
                    <a href="{{ route('events.index') }}" class="btn-close" title="Cancelar y volver">×</a>
                </div>

                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>¡Ups! Ocurrieron algunos errores:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Título del Evento</label>
                            <input type="text" name="title" class="form-control" placeholder="Ej: Festival Primavera 2025" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Describe brevemente el evento..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lugar</label>
                            <select name="place_id" class="form-select" required>
                                <option value="" disabled selected>Selecciona un lugar disponible...</option>
                                @foreach($places as $place)
                                    <option value="{{ $place->id }}">
                                        {{ $place->name }} - {{ $place->location }} (Capacidad: {{ $place->max_capacity }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text">* Las secciones y asientos están definidos en el lugar.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Categoría</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled selected>Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Fecha de Inicio</label>
                                <input type="date" name="fecha_de_inicio" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Fecha de Finalización</label>
                                <input type="date" name="fecha_finalizacion" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Imagen del Evento</label>
                            <input type="file" name="logo_image" class="form-control">
                            <small class="form-text">Formatos válidos: JPG, PNG. Tamaño máximo: 2MB.</small>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle-fill me-1"></i> Crear Evento
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
