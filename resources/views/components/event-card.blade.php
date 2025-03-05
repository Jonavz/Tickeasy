@props(['event'])

<div class="event-card">
    <a href="{{ route('events.show', $event->id) }}" class="event-link">
        <img src="{{ asset('storage/' . $event->logo_image) }}" alt="Imagen de {{ $event->title }}" class="event-image">
        <div class="event-info">
            <p class="event-date">{{ \Carbon\Carbon::parse($event->fecha_de_inicio)->format('d/m/y') }}</p>
            <h2 class="event-title">{{ $event->title }}</h2>
            <p class="event-location">{{ $event->place ? $event->place->name : 'Ubicación no definida' }}</p>
            <p class="event-price"><strong>Desde ${{ number_format($event->price, 2) }}</strong></p>
        </div>
    </a>
</div>
