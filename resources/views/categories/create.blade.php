@extends('layouts.app')

@section('content')
<x-navbar />

<div class="crud-container">
    <h1>Crear Categoría</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" name="name" required>

        <label for="description">Descripción:</label>
        <textarea name="description"></textarea>

        <button type="submit">Crear Categoría</button>
    </form>
</div>
@endsection
