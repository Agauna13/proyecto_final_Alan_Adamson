@extends('frontend.layout')

@section('content')

<div class="p-6 text-white">
    <h2 class="text-2xl font-bold mb-6">Confirmación del Pedido</h2>

    @if ($reservaData)
        <div class="mb-4">
            <strong>Reserva:</strong> {{ $reservaData['nombre'] }} — {{ $reservaData['fecha'] }} a las {{ $reservaData['hora'] }}
        </div>
    @endif

    @if ($mesa)
        <div class="mb-4">
            <strong>Mesa:</strong> {{ $mesa->id }}
        </div>
    @endif

    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf

        <h3 class="text-xl font-semibold mb-2">Productos seleccionados:</h3>

        @foreach ($productosUnicos as $index => $producto)
            <div class="border border-gray-600 rounded p-4 mb-4">
                <input type="hidden" name="productos[{{ $index }}][producto_id]" value="{{ $producto->id }}">
                <input type="hidden" name="productos[{{ $index }}][cantidad]" value="1">
                <input type="hidden" name="productos[{{ $index }}][precio_unitario]" value="{{ $producto->precio }}">

                <p><strong>{{ $producto->nombre }}</strong> ({{ number_format($producto->precio, 2) }} €)</p>

                @if ($producto->extras->isNotEmpty())
                    <div class="mt-2 ml-4">
                        <p class="italic text-sm">Selecciona extras para esta unidad:</p>

                        @foreach ($producto->extras as $extra)
                            <div class="flex items-center gap-2 text-sm mt-1">
                                <label>
                                    <input type="number" name="productos[{{ $index }}][extras_por_unidad][{{ $extra->id }}]" min="0" value="0" class="w-16 text-black">
                                    {{ $extra->nombre }} (+{{ number_format($extra->precio, 2) }} €)
                                </label>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="ml-4 text-sm italic text-gray-400">Sin extras disponibles</p>
                @endif
            </div>
        @endforeach

        @if ($entrantes->isNotEmpty())
            <h3 class="text-xl font-semibold mt-6 mb-2">Entrantes opcionales:</h3>

            @foreach ($entrantes as $entrante)
                <div class="flex items-center justify-between mb-2">
                    <label>{{ $entrante->nombre }} ({{ number_format($entrante->precio, 2) }} €)</label>
                    <input type="number" name="extras_entrantes[{{ $entrante->id }}]" min="0" value="0" class="w-16 text-black">
                </div>
            @endforeach
        @endif

        <div class="mt-6">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">
                Confirmar Pedido
            </button>
        </div>
    </form>
</div>
@if (session('error'))
    <div class="alert alert-danger">
        <p class="text-red-600">{{ session('error') }}</p>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
