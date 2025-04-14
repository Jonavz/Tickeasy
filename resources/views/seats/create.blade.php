@extends('layouts.app')

@section('content')
<div class="crud-container">
    <h1>Crear Asiento</h1>

    <form action="{{ route('seats.store') }}" method="POST">
        @csrf

        <label for="section_id">Sección:</label>
        <select name="section_id" required>
            @foreach($sections as $section)
                <option value="{{ $section->id }}">
                    {{ $section->name }} - {{ $section->place->name }}
                </option>
            @endforeach
        </select>

        <label for="seat_number">Número del asiento (Ej: A1):</label>
        <input type="text" name="seat_number" required>

        <button type="submit">Guardar asiento</button>
    </form>
</div>
@endsection
