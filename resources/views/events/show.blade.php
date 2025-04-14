@extends('layouts.app')

@section('content')
<x-navbar />

<div class="container py-5">
    <div class="row align-items-start">

        <div class="col-lg-6 mb-5 text-white">

            @if ($event->logo_image)
                <img src="{{ asset('storage/' . $event->logo_image) }}" class="img-fluid mb-4 rounded shadow" alt="{{ $event->title }}" style="max-height: 320px;">
            @endif

            <h1 class="fw-bold">{{ $event->title }}</h1>
            <p class="text-light">
                <i class="bi bi-calendar-event-fill"></i>
                {{ \Carbon\Carbon::parse($event->fecha_de_inicio)->format('d M Y') }}
                - {{ \Carbon\Carbon::parse($event->fecha_finalizacion)->format('d M Y') }}
            </p>

            <p class="text-light">
                <i class="bi bi-geo-alt-fill"></i>
                <strong>Ubicación:</strong> {{ $event->place->name }}
            </p>

            <p class="text-light">{{ $event->description }}</p>
        </div>


        <div class="col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header border-black medium text-white text-center">
                    <h5 class="mb-0"> Selecciona Sección y Boletos</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('cart.add', $event) }}" method="POST" id="ticket-form">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-white">Sección</label>
                            <select name="section_id" class="form-select" id="section-select" required>
                                <option value="" disabled selected>Selecciona una sección</option>
                                @foreach($event->place->sections as $section)
                                    @php
                                        $available = $section->seats->where('is_taken', false)->count();
                                    @endphp
                                    @if($available > 0)
                                        <option
                                            value="{{ $section->id }}"
                                            data-price="{{ $section->price }}"
                                            data-available="{{ $available }}"
                                        >
                                            {{ $section->name }} — ${{ number_format($section->price, 2) }} ({{ $available }} disponibles)
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-white">Cantidad</label>
                            <input type="number" name="quantity" class="form-control" id="quantity-input" min="1" max="1" value="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-white">Total a pagar</label>
                            <div class="form-control bg-light fw-bold text-primary">$
                                <span id="total">0.00</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-cart-plus-fill me-1"></i> Añadir al Carrito
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
<x-footer />

<script>
    const sectionSelect = document.getElementById('section-select');
    const quantityInput = document.getElementById('quantity-input');
    const totalDisplay = document.getElementById('total');

    function updateTotal() {
        const price = parseFloat(sectionSelect.selectedOptions[0]?.dataset?.price || 0);
        const qty = parseInt(quantityInput.value || 1);
        totalDisplay.textContent = (price * qty).toFixed(2);
    }

    sectionSelect?.addEventListener('change', () => {
        const available = sectionSelect.selectedOptions[0]?.dataset?.available || 1;
        quantityInput.max = available;
        quantityInput.value = 1;
        updateTotal();
    });

    quantityInput?.addEventListener('input', updateTotal);
</script>
@endsection
