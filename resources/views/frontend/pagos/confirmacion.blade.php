@extends('frontend.layout')

@section('content')
<div class="p-6 text-white">
    <h2 class="text-2xl font-bold mb-4">Resumen del Pedido</h2>

    @foreach ($pedido->productos as $producto)
        @php
            $pivot = $producto->pivot;
            $extras = DB::table('extra_pedido_producto')
                ->where('pedido_producto_id', $pivot->id)
                ->join('extras', 'extras.id', '=', 'extra_pedido_producto.extra_id')
                ->select('extras.nombre', 'extra_pedido_producto.cantidad', 'extras.precio')
                ->get();

            $subtotalExtras = $extras->sum(function ($extra) {
                return $extra->precio * $extra->cantidad;
            });

            $totalLinea = $pivot->precio_unitario + $subtotalExtras;
        @endphp

        <div class="border-b border-gray-500 py-4">
            <p><strong>Producto:</strong> {{ $producto->nombre }} (ID: {{ $producto->id }})</p>
            <p><strong>Precio unitario:</strong> {{ number_format($pivot->precio_unitario, 2) }} €</p>
            <p><strong>Extras:</strong></p>

            @if ($extras->isNotEmpty())
                <ul class="ml-4 list-disc">
                    @foreach ($extras as $extra)
                        <li>
                            {{ $extra->nombre }} × {{ $extra->cantidad }}
                            ({{ number_format($extra->precio, 2) }} € c/u)
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="ml-4 italic text-sm text-gray-400">Sin extras</p>
            @endif

            <p><strong>Total por esta unidad:</strong> {{ number_format($totalLinea, 2) }} €</p>
        </div>
    @endforeach

    <div class="mt-6 text-lg font-bold">
        @php
            $total = $pedido->productos->sum(function ($producto) {
                $pivotId = $producto->pivot->id;
                $extras = DB::table('extra_pedido_producto')
                    ->where('pedido_producto_id', $pivotId)
                    ->join('extras', 'extras.id', '=', 'extra_pedido_producto.extra_id')
                    ->select('extras.precio', 'extra_pedido_producto.cantidad')
                    ->get();

                $subtotalExtras = $extras->sum(function ($extra) {
                    return $extra->precio * $extra->cantidad;
                });

                return $producto->pivot->precio_unitario + $subtotalExtras;
            });
        @endphp

        Total del pedido: {{ number_format($total, 2) }} €
    </div>
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
