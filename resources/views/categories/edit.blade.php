@extends('layouts.app')

@section('content')
<x-navbar />

<style>
    body { background-color: #0B1120; font-family: 'Lato', sans-serif; }
    .form-label { color: #fff; }
    .form-control {
        background-color: #1f2937;
        border-color: #374151;
        color: #f3f4f6;
    }
    .card { background-color: #111827; color: white; border: 1px solid #1e3a8a; }
    .btn-close { position: absolute; top: 10px; right: 20px; color: white; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg position-relative">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Editar Categoría</h3>
                    <a href="{{ route('categories.index') }}" class="btn-close" title="Cancelar y volver">×</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('categories.update', $categoria->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{ $categoria->name }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="form-control" rows="3">{{ $categoria->description }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-save-fill"></i> Actualizar Categoría
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
