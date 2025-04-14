@extends('layouts.app')

@section('content')
<div class="crud-container">
    <h1>Crear Sección</h1>

    <form action="{{ route('sections.store') }}" method="POST">
        @csrf

        <label for="place_id">Lugar:</label>
        <select name="place_id" required>
            @foreach($places as $place)
                <option value="{{ $place->id }}">{{ $place->name }}</option>
            @endforeach
        </select>

        <label for="name">Nombre de la sección:</label>
        <input type="text" name="name" required>

        <label for="price">Precio por asiento:</label>
        <input type="number" step="0.01" name="price" required>

        <button type="submit">Guardar sección</button>
    </form>
</div>
@endsection
