@extends('layouts.app')

@section('content')
<x-navbar />

<div class="container">
    <h1>Eventos Disponibles</h1>

    <div class="event-grid">
        @foreach ($events as $event)
            <x-event-card :event="$event" />
        @endforeach
    </div>
</div>
@endsection
