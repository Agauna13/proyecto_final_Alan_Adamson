@extends('frontend.layout')

@section('content')

<section class="bg-black text-white py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-semibold mb-4">¡Reserva confirmada!</h2>

        <div class="bg-gray-800 p-6 rounded-lg shadow-md">
            <p class="text-lg mb-4">Gracias, <span class="font-semibold">{{ $cliente->nombre }}</span>. Hemos registrado tu reserva.</p>

            <div class="border-t border-gray-700 pt-4">
                <p><span class="font-semibold">Teléfono:</span> {{ $cliente->telefono }}</p>
                <p><span class="font-semibold">Email:</span> {{ $cliente->email }}</p>
                <p><span class="font-semibold">Fecha:</span> {{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</p>
                <p><span class="font-semibold">Hora:</span> {{ \Carbon\Carbon::parse($reserva->hora)->format('H:i') }}</p>
                <p><span class="font-semibold">Número de personas:</span> {{ $reserva->pax }}</p>
                <p><span class="font-semibold">Ubicación:</span> {{ ucfirst($reserva->sala_terraza) }}</p>
            </div>

            <div class="mt-6">
                <a href="{{ route('home') }}"
                    class="inline-block bg-red-600 hover:bg-white hover:text-red-600 transition px-6 py-2.5 rounded-md text-sm font-medium">
                    Volver a la página principal
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
