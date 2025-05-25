@extends('backend.layout')

@section('content')
<div class="p-4 sm:p-6 bg-white rounded-xl shadow-md max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-blue-700 tracking-wide">Listado de Pedidos</h1>

    </div>

    <div class="overflow-x-auto rounded shadow ring-1 ring-gray-200">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-50 sticky top-0">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold">Pedido</th>
                    <th class="px-4 py-2 text-left font-semibold">Cliente (Reserva)</th>
                    <th class="px-4 py-2 text-left font-semibold">Mesa</th>
                    <th class="px-4 py-2 text-left font-semibold">Hora Reserva</th>
                    <th class="px-4 py-2 text-left font-semibold">Hora Pedido</th>
                    <th class="px-4 py-2 text-left font-semibold">Precio Total (€)</th>
                    <th class="px-4 py-2 text-left font-semibold">Estado</th>
                    <th class="px-4 py-2 text-left font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($pedidos as $pedido)
                    @php
                        $totalProductos = $pedido->pedidoProductos->sum('precio_unitario');
                        $totalExtras = $pedido->pedidoProductos->flatMap(function ($unidad) {
                            return $unidad->extras->map(function ($extra) {
                                return $extra->precio * $extra->pivot->cantidad;
                            });
                        })->sum();
                        $precioTotal = $totalProductos + $totalExtras;
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $pedido->id }}</td>
                        <td class="px-4 py-2">{{ $pedido->reserva->cliente->nombre ?? $pedido->reserva->nombre ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $pedido->mesa->id ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $pedido->reserva->hora ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $pedido->created_at ?? '-' }}</td>
                        <td class="px-4 py-2 font-semibold">{{ number_format($precioTotal, 2) }} €</td>
                        <td class="px-4 py-2 font-semibold">{{ $pedido->estado }}</td>
                        <td class="px-4 py-2 flex flex-wrap gap-1">
                            <a href="{{ route('admin.pedidos.show', $pedido) }}"
                                class="px-3 py-1 bg-blue-800 text-white hover:bg-white hover:text-blue-800 rounded transition text-xs sm:text-sm shadow">
                                Ver
                            </a>
                            <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-700 text-white hover:bg-white hover:text-red-700 rounded transition text-xs sm:text-sm shadow font-semibold">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
