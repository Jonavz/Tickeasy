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
                    <h3 class="mb-0">Editar Evento</h3>
                    <a href="{{ route('events.index') }}" class="btn-close" title="Cancelar y volver">×</a>
                </div>

                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Ups, hubo errores:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Título del Evento</label>
                            <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ $event->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lugar</label>
                            <select name="place_id" class="form-select" required>
                                @foreach($places as $place)
                                    <option value="{{ $place->id }}" {{ $event->place_id == $place->id ? 'selected' : '' }}>
                                        {{ $place->name }} - {{ $place->location }} (Capacidad: {{ $place->max_capacity }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text">* Las secciones y asientos están definidos desde el lugar.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Categoría</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Fecha de Inicio</label>
                                <input type="date" name="fecha_de_inicio" class="form-control" value="{{ $event->fecha_de_inicio }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Fecha de Finalización</label>
                                <input type="date" name="fecha_finalizacion" class="form-control" value="{{ $event->fecha_finalizacion }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Imagen del Evento</label>
                            @if ($event->logo_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $event->logo_image) }}" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                            <input type="file" name="logo_image" class="form-control">
                            <small class="form-text">Formatos permitidos: JPG, PNG. Máx: 2MB</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
