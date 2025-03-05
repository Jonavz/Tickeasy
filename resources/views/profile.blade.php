@extends('layouts.app')

@section('content')

<!-- Navbar -->
<x-navbar />

<div class="container-profile">
    <h1>Perfil de Usuario</h1>

    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ $user->name }}" required>

        <label for="last_name">Apellido:</label>
        <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="{{ $user->email }}" required>

        <label for="password">Nueva Contraseña (opcional):</label>
        <input type="password" id="password" name="password">

        <label for="password_confirmation">Confirmar Contraseña:</label>
        <input type="password" id="password_confirmation" name="password_confirmation">

        <button type="submit">Actualizar Perfil</button>
    </form>
</div>

@endsection
