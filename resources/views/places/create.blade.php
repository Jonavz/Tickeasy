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

        <hr>
        <h3>Secciones y Asientos</h3>

        <div id="sections-container"></div>

        <button type="button" id="add-section">+ Agregar Sección</button>

        <br><br>
        <button type="submit">Guardar Ubicación</button>
    </form>
</div>

<script>
    let sectionCount = 0;

    document.getElementById('add-section').addEventListener('click', () => {
        const container = document.getElementById('sections-container');

        const sectionDiv = document.createElement('div');
        sectionDiv.classList.add('section-group');
        sectionDiv.style.marginBottom = '20px';
        sectionDiv.style.border = '1px solid #ccc';
        sectionDiv.style.padding = '10px';

        sectionDiv.innerHTML = `
            <h4>Sección ${sectionCount + 1}</h4>

            <label>Nombre:</label>
            <input type="text" name="sections[${sectionCount}][name]" required>

            <label>Precio por Asiento:</label>
            <input type="number" step="0.01" name="sections[${sectionCount}][price]" required>

            <label>Cantidad de Asientos:</label>
            <input type="number" name="sections[${sectionCount}][quantity]" min="1" required>

            <button type="button" class="remove-section" style="background:red; color:white; margin-top:10px;">Eliminar Sección</button>
        `;

        container.appendChild(sectionDiv);
        sectionCount++;
    });

    // Delegar evento de eliminar sección
    document.getElementById('sections-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-section')) {
            e.target.closest('.section-group').remove();
        }
    });
</script>
@endsection
