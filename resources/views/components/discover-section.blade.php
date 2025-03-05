@props(['randomEvents' => collect()])

<div class="discover-section h2">
    <h1>Descubre nuevas Experiencias!</h1>

    <div class="discover-section">
        @foreach ($randomEvents as $event)
            <x-event-card :event="$event" />
        @endforeach
    </div>
</div>
