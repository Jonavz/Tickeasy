@props(['randomEvents' => collect()])

<div class="container my-5">
    <h2 class="text-start mb-4 fw-bold text-white"> Descubre nuevas Experiencias</h2><br>

    @if($randomEvents->isEmpty())
        <div class="text-center text-muted">No hay eventos disponibles en este momento.</div>
    @else
        <div class="row justify-content-start">
            @foreach ($randomEvents as $event)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-sm h-100 border-0">
                        @if ($event->logo_image)
                            <img src="{{ asset('storage/' . $event->logo_image) }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="{{ $event->title }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-white fw-semibold">{{ $event->title }}</h5>
                            <p class="card-text text-white small">{{ \Illuminate\Support\Str::limit($event->description, 80) }}</p>
                            <p class="mb-1 text-white "><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($event->fecha_de_inicio)->format('d/m/Y') }}</p>
                            <p class="mb-1 text-white "><i class="bi bi-geo-alt"></i> {{ $event->place->name }}</p>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-primary mt-auto w-100">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
