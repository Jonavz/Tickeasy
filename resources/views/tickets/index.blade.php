@extends('layouts.app')

@section('content')
<x-navbar />

<div class="container py-5">
    <div class="text-center text-white mb-5">
        <h2 class="fw-bold" style="font-family: 'Lato', sans-serif;">Mis Boletos</h2>
        <p class="text-white">Aquí encontrarás todos los boletos que has adquirido</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($tickets->count() > 0)
        <div class="table-responsive">
            <table class="table table-dark table-bordered table-striped shadow-sm rounded text-center">
                <thead class="table-primary text-dark">
                    <tr>
                        <th>Evento</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td class="fw-semibold">{{ $ticket->event->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($ticket->event->fecha_de_inicio)->format('d/m/Y') }}</td>
                            <td>{{ $ticket->quantity }}</td>
                            <td>${{ number_format($ticket->amount_paid, 2) }}</td>
                            <td>
                                <span class="badge bg-success px-3 py-2 fs-6">{{ $ticket->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning text-center">Aún no has comprado boletos.</div>
    @endif
</div>
<x-footer />
@endsection
