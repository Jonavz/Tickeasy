@extends('layouts.app')

@section('content')
<x-navbar />

<div class="crud-container">
    <h1>Agregar Nueva Ubicación</h1>

    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('places.store') }}" method="POST">
        @csrf

        <label for="name">Nombre del Lugar:</label>
        <input type="text" name="name" required>

        <label for="location">Dirección:</label>
        <input type="text" name="location" required>

        <label for="max_capacity">Capacidad Máxima:</label>
        <input type="number" name="max_capacity" min="1" required>

        <button type="submit">Guardar Ubicación</button>
    </form>
</div>
@endsection
