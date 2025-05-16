@extends('backend.layout')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Lista de Pedidos</h1>

    @if ($pedidos->count())
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left px-4 py-2 border">ID</th>
                    <th class="text-left px-4 py-2 border">Mesa</th>
                    <th class="text-left px-4 py-2 border">Reserva</th>
                    <th class="text-left px-4 py-2 border">Productos</th>
                    <th class="text-left px-4 py-2 border">Factura</th>
                    <th class="text-left px-4 py-2 border">Fecha de Pedido</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td class="px-4 py-2 border">{{ $pedido->id }}</td>

                        <td class="px-4 py-2 border">
                            {{ $pedido->mesa->id ?? 'Sin mesa' }}
                        </td>

                        <td class="px-4 py-2 border">
                            @if ($pedido->reserva)
                                {{ $pedido->reserva->cliente->nombre ?? 'Cliente' }}<br>
                                {{ $pedido->reserva->fecha }} {{ $pedido->reserva->hora }}
                            @else
                                Sin reserva
                            @endif
                        </td>

                        <td class="px-4 py-2 border">
                            <ul>
                                @foreach ($pedido->productos as $producto)
                                    <li>
                                        {{ $producto->nombre }} × {{ $producto->pivot->cantidad }}
                                        ({{ number_format($producto->pivot->precio, 2) }} € c/u)
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        <td class="px-4 py-2 border">
                            {{ $pedido->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay pedidos registrados.</p>
    @endif
</div>
@endsection
