@extends('layouts.app')

@section('content')
<x-navbar />

<div class="crud-container">
    <h1>Editar Ubicación</h1>

    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('places.update', $place->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nombre del Lugar:</label>
        <input type="text" name="name" value="{{ $place->name }}" required>

        <label for="location">Dirección:</label>
        <input type="text" name="location" value="{{ $place->location }}" required>

        <label for="max_capacity">Capacidad Máxima:</label>
        <input type="number" name="max_capacity" value="{{ $place->max_capacity }}" min="1" required>

        <button type="submit">Actualizar Ubicación</button>
    </form>
</div>
@endsection
