@extends('backend.layout')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-lg space-y-8">
        <header>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Detalle del Pedido</h1>
            <h2 class="text-2xl font-bold text-green-700 mb-2">#{{ $pedido->id }}</h2>
            <div class="text-gray-700 space-y-1">
                <p><strong>Cliente:</strong> {{ $pedido->reserva->cliente->nombre }}</p>
                <p><strong>Fecha de la reserva:</strong> {{ $pedido->reserva->fecha }}</p>
                <p><strong>Hora de la reserva:</strong> {{ $pedido->reserva->hora }}</p>
                <p><strong>Comensales:</strong> {{ $pedido->reserva->pax }}</p>
                @if($pedido->estado === 'pendiente')
                <p class="text-red-600"><strong>Estado:</strong> {{ $pedido->estado }}</p>
                @endif
                @if($pedido->estado === 'servido')
                <p class="text-green-600"><strong>Estado:</strong> {{ $pedido->estado }}</p>
                @endif
                @if($pedido->estado === 'confirmado')
                <p class="text-yellow-600"><strong>Estado:</strong> {{ $pedido->estado }}</p>
                @endif
            </div>
        </header>

        <section class="bg-gray-50 border border-gray-300 rounded-lg p-6 space-y-6">
            @foreach ($pedido->pedidoProductos as $unidad)
                <article class="flex border-b border-gray-300 pb-4 last:border-0 last:pb-0 items-center">
                    <div class="w-1/2 text-lg font-semibold text-gray-800">
                        {{ $unidad->producto->nombre }}, {{$unidad->producto->precio}} €
                    </div>
                    <div class="w-1/2 text-gray-700 text-sm flex flex-wrap gap-x-2 gap-y-1">
                        @if ($unidad->extras->isNotEmpty())
                            @foreach ($unidad->extras as $index => $extra)
                                <span>
                                    {{ $extra->nombre }}
                                    (<span class="font-semibold">{{ number_format($extra->precio, 2) }}</span>)
                                    @if (!$loop->last)
                                        <span class="mx-1 text-gray-400">•</span>
                                    @endif
                                </span>
                            @endforeach
                        @else
                            <span class="italic text-gray-500">Sin extras</span>
                        @endif
                    </div>
                </article>
            @endforeach

            <div class="mt-6 text-right text-lg font-bold text-gray-900">
                Total: {{ number_format($precioTotal, 2) }} €
            </div>
        </section>

        <footer class="flex justify-end gap-4">
            <a href="{{ route('admin.pedidos.edit', $pedido->id) }}"
                class="px-6 py-2 bg-gray-800 text-white rounded shadow hover:bg-gray-900 transition font-semibold">
                Editar
            </a>

            <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST"
                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-6 py-2 bg-red-600 text-white rounded shadow hover:bg-red-700 transition font-semibold">
                    Eliminar
                </button>
            </form>
        </footer>
    </div>
@endsection
