@extends('layouts.app')

@section('content')
<x-navbar />

<div class="crud-container">
    <h1>Gestión de Lugares</h1>
    <a href="{{ route('places.create') }}" class="btn btn-primary">Agregar Lugar</a>

    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Capacidad Máxima</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($places as $place)
                <tr>
                    <td>{{ $place->name }}</td>
                    <td>{{ $place->location }}</td>
                    <td>{{ $place->max_capacity }}</td>
                    <td>
                        <a href="{{ route('places.edit', $place->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('places.destroy', $place->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
