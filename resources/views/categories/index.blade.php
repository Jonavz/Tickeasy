@extends('layouts.app')

@section('content')
<x-navbar />

<style>
    body {font-family: 'Lato', sans-serif; }
    .table { color: white; }
    .table th, .table td { vertical-align: middle; }
    .table-dark { background-color: #142446; }
    .btn-danger { background-color: #dc3545; }
    .btn-warning { background-color: #ffc107; color: black; }
</style>

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Lista de Categorías</h3>
            <a href="{{ route('categories.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Nueva Categoría
            </a>
        </div>

        <div class="card-body p-4  rounded-bottom">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-dark table-hover table-bordered">
                    <thead class="table-primary text-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td class="text-center">
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($categories->isEmpty())
                    <p class="text-center text-white mt-4">No hay categorías registradas.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
