@extends('backend.layout')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-blue-700 tracking-wide">Listado de Pedidos</h1>
        <a href="{{ route('admin.pedidos.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-semibold">
            Nuevo Pedido
        </a>
    </div>

    <div class="overflow-x-auto">
        <div class="overflow-y-auto max-h-[400px]">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="sticky top-0 bg-gray-50 px-4 py-2 text-left font-semibold text-gray-600">Pedido</th>
                        <th class="sticky top-0 bg-gray-50 px-4 py-2 text-left font-semibold text-gray-600">Cliente (Reserva)</th>
                        <th class="sticky top-0 bg-gray-50 px-4 py-2 text-left font-semibold text-gray-600">Mesa</th>
                        <th class="sticky top-0 bg-gray-50 px-4 py-2 text-left font-semibold text-gray-600">Hora Reserva</th>
                        <th class="sticky top-0 bg-gray-50 px-4 py-2 text-left font-semibold text-gray-600">Precio Total (€)</th>
                        <th class="sticky top-0 bg-gray-50 px-4 py-2 text-left font-semibold text-gray-600">Acciones</th>
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
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $pedido->id }}</td>
                            <td class="px-4 py-2">{{ $pedido->reserva->cliente->nombre ?? $pedido->reserva->nombre ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $pedido->mesa->id ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $pedido->reserva->hora ?? '-' }}</td>
                            <td class="px-4 py-2 font-semibold">{{ number_format($precioTotal, 2) }} €</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.pedidos.show', $pedido) }}"
                                    class="inline-block px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded transition font-medium">
                                    Ver
                                </a>
                                <a href="{{ route('admin.pedidos.edit', $pedido) }}"
                                    class="inline-block px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded transition font-medium">
                                    Editar
                                </a>
                                <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded transition font-medium">
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
</div>
@endsection
