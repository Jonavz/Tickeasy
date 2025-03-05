@extends('layouts.app')

@section('content')
<x-navbar />

<div class="crud-containerr">
    <h1>Editar Evento</h1>

    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="title">Título:</label>
        <input type="text" name="title" value="{{ $event->title }}" required>

        <label for="description">Descripción:</label>
        <textarea name="description" required>{{ $event->description }}</textarea>

        <label for="price">Precio:</label>
        <input type="number" name="price" value="{{ $event->price }}" required>

        <label for="category_id">Categoría:</label>
        <select name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label for="place_id">Lugar:</label>
        <select name="place_id" required>
            @foreach($places as $place)
                <option value="{{ $place->id }}" {{ $event->place_id == $place->id ? 'selected' : '' }}>
                    {{ $place->name }} (Capacidad: {{ $place->max_capacity }})
                </option>
            @endforeach
        </select>

        <label for="fecha_de_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_de_inicio" value="{{ $event->fecha_de_inicio }}" required>

        <label for="fecha_finalizacion">Fecha Finalización:</label>
        <input type="date" name="fecha_finalizacion" value="{{ $event->fecha_finalizacion }}" required>

        <label for="logo_image">Imagen del Evento:</label>
        @if ($event->logo_image)
            <p>Imagen actual:</p>
            <img src="{{ asset($event->logo_image) }}" width="150">
        @endif
        <input type="file" name="logo_image">

        <button type="submit">Actualizar Evento</button>
    </form>
</div>
@endsection
