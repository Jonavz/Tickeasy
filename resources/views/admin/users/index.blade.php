@extends('layouts.app')

@section('content')
<x-navbar />

<style>
    body {
        font-family: 'Lato', sans-serif;
    }

    .admin-users-container {
        max-width: 1100px;
        margin: 50px auto;
        padding: 30px;
        background-color: #121f3d; /* Azul oscuro */
        color: #ffffff;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.4);
    }

    .admin-users-container h1 {
        font-weight: 800;
        text-align: center;
        margin-bottom: 30px;
        font-size: 26px;
        font-family: 'Lato', sans-serif;
        color: #ffffff;
    }

    .admin-users-container h1::before {
        font-family: 'Lato', sans-serif;
        font-size: 28px;
        margin-right: 8px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #112240; /* Azul oscuro más claro */
        border: 1px solid #00BFFF;
        border-radius: 10px #000000;
        overflow: hidden;
    }

    th, td {
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #223344;
    }

    th {
        background-color: #112240;
        color: #00BFFF;
        font-weight: 600;
    }

    tr:last-child td {
        border-bottom: none;
    }

    select {
        background-color: #0D1B2A;
        color: #ffffff;
        border: 1px solid #00BFFF;
        padding: 6px 10px;
        border-radius: 5px;
        font-family: 'Lato', sans-serif;
    }

    select:focus {
        outline: none;
        box-shadow: 0 0 4px #00BFFF;
    }

    .btn-danger {
        background-color: transparent;
        color: #ff4d4d;
        border: 1px solid #ff4d4d;
        padding: 6px 12px;
        border-radius: 5px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #ff4d4d;
        color: white;
    }

    .text-muted {
        color: #ff4d4d;
        font-weight: bold;
    }

    .success-message,
    .error-message {
        background-color: #112240;
        padding: 12px 18px;
        border-left: 4px solid;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .success-message {
        border-color: #28a745;
        color: #28a745;
    }

    .error-message {
        border-color: #dc3545;
        color: #dc3545;
    }
</style>

<div class="admin-users-container">
    <h1>Administración de Usuarios</h1>

    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="error-message">{{ session('error') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }} {{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST">
                        @csrf
                        <select name="role" onchange="this.form.submit()">
                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Administrador</option>
                            <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Usuario</option>
                        </select>
                    </form>
                </td>
                <td>
                    @if($user->role != 1)
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">Eliminar</button>
                        </form>
                    @else
                        <span class="text-danger">No se puede eliminar</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
