@extends('layouts.app')

@section('content')
<x-navbar />

<div class="crud-container">
    <h1>Crear Evento</h1>

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="title">Título:</label>
        <input type="text" name="title" required>

        <label for="description">Descripción:</label>
        <textarea name="description" required></textarea>

        <label for="place_id">Lugar:</label>
        <select name="place_id" required>
            @foreach($places as $place)
                <option value="{{ $place->id }}">{{ $place->name }} (Capacidad: {{ $place->max_capacity }})</option>
            @endforeach
        </select>


        <label for="price">Precio:</label>
        <input type="number" name="price" required>

        <label for="category_id">Categoría:</label>
        <select name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="fecha_de_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_de_inicio" required>

        <label for="fecha_finalizacion">Fecha Finalización:</label>
        <input type="date" name="fecha_finalizacion" required>

        <label for="logo_image">Imagen del Evento:</label>
        <input type="file" name="logo_image">

        <button type="submit">Crear Evento</button>
    </form>
</div>
@endsection
