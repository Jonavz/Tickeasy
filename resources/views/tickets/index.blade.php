@extends('layouts.app')

@section('content')
<x-navbar />

<div class="crud-container">
    <h1>Mis Boletos</h1>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    @if($tickets->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Total Pagado</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->event->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($ticket->event->fecha_de_inicio)->format('d/m/y') }}</td>
                        <td>{{ $ticket->quantity }}</td>
                        <td>${{ number_format($ticket->amount_paid, 2) }}</td>
                        <td>{{ $ticket->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No tienes boletos comprados.</p>
    @endif
</div>
@endsection
