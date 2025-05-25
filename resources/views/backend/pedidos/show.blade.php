@extends('backend.layout')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-lg space-y-8">
        <header>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Detalle del Pedido</h1>
            <h2 class="text-2xl font-bold text-green-700 mb-2">#{{ $pedido->id }}</h2>
            <h3 class="font-bold text-gray-700 mb-2">Hora del pedido: {{ $pedido->created_at }}</h3>

            <div class="text-gray-700 space-y-1">
                @if ($pedido->reserva)
                    <p><strong>Cliente:</strong> {{ $pedido->reserva->cliente->nombre }}</p>
                    <p><strong>Fecha de la reserva:</strong> {{ $pedido->reserva->fecha }}</p>
                    <p><strong>Hora de la reserva:</strong> {{ $pedido->reserva->hora }}</p>
                    <p><strong>Comensales:</strong> {{ $pedido->reserva->pax }}</p>
                @else
                    <p><strong>Mesa:</strong> {{ $pedido->mesa->id ?? 'Sin número de mesa' }}</p>
                @endif

                <p>
                    <strong>Estado:</strong>
                    <span class="
                        @if ($pedido->estado === 'pendiente') text-red-600
                        @elseif ($pedido->estado === 'servido') text-green-600
                        @elseif ($pedido->estado === 'confirmado') text-yellow-600
                        @endif font-semibold">
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </p>
            </div>
        </header>

        <section class="bg-gray-50 border border-gray-300 rounded-lg p-6 space-y-6">
            @foreach ($pedido->pedidoProductos as $unidad)
                <article class="flex border-b border-gray-300 pb-4 last:border-0 last:pb-0 items-center">
                    <div class="w-1/2 text-lg font-semibold text-gray-800">
                        {{ $unidad->producto->nombre }}, {{ $unidad->producto->precio }} €
                    </div>
                    <div class="w-1/2 text-gray-700 text-sm flex flex-wrap gap-x-2 gap-y-1">
                        @if ($unidad->extras->isNotEmpty())
                            @foreach ($unidad->extras as $extra)
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

        <footer class="flex flex-wrap justify-evenly gap-4">
            <form action="{{ route('admin.pedidos.estado', ['pedido' => $pedido->id, 'estado' => 'pendiente']) }}"
                method="POST" onsubmit="return confirm('¿Estás seguro de confirmar este pedido?');">
                @csrf
                <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700 transition font-semibold">
                    Marcar como pendiente
                </button>
            </form>

            <form action="{{ route('admin.pedidos.estado', ['pedido' => $pedido->id, 'estado' => 'servido']) }}"
                method="POST" onsubmit="return confirm('¿Estás seguro de marcar este pedido como servido?');">
                @csrf
                <button type="submit"
                    class="px-6 py-2 bg-yellow-500 text-white rounded shadow hover:bg-yellow-600 transition font-semibold">
                    Marcar como Servido
                </button>
            </form>

            <form action="{{ route('admin.pedidos.estado', ['pedido' => $pedido->id, 'estado' => 'cancelado']) }}"
                method="POST" onsubmit="return confirm('¿Estás seguro de cancelar este pedido?');">
                @csrf
                <button type="submit"
                    class="px-6 py-2 bg-red-600 text-white rounded shadow hover:bg-red-700 transition font-semibold">
                    Cancelar Pedido
                </button>
            </form>

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
