<div class="container">
    <h1>Eventos Disponibles</h1>

    <div class="event-grid">
        @foreach ($randomEvents as $event)
            <x-event-card :event="$event" />
        @endforeach
    </div>
    
</div>



