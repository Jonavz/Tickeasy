@extends('layouts.app')

@section('content')
<x-navbar />

<div class="crud-container">
    <h1>Editar Categoría</h1>

    <form action="{{ route('categories.update', $categoria->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nombre:</label>
        <input type="text" name="name" value="{{ $categoria->name }}" required>

        <label for="description">Descripción:</label>
        <textarea name="description">{{ $categoria->description }}</textarea>

        <button type="submit">Actualizar Categoría</button>
    </form>
</div>
@endsection
