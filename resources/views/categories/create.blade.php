@extends('layouts.app')

@section('content')
<x-navbar />

<style>
    body {  font-family: 'Lato', sans-serif; }
    .form-label { color: #fff; }
    .form-control, .form-select {
        background-color: #1f2937;
        border-color: #374151;
        color: #2a416d;
    }
    .card { background-color: #121e36; color: white; border: 1px solid #0f2050; }
    .btn-close { position: absolute; top: 10px; right: 20px; color: white; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg position-relative">
                <div class="card-header  text-white text-center">
                    <h3 class="mb-0">Crear Categoría</h3>
                    <a href="{{ route('categories.index') }}" class="btn-close" title="Cancelar y volver">×</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle-fill"></i> Guardar Categoría
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
