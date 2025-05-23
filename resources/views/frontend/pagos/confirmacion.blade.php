@extends('frontend.layout')

@section('content')
<div class="p-6 text-white">
<h2>Pedido #{{ $pedido->id }}</h2>

<h3>Productos</h3>

@foreach ($pedido->pedidoProductos as $unidad)
    <div class="border-b border-gray-600 py-2">
        <strong>{{ $unidad->producto->nombre }}</strong> - {{ number_format($unidad->precio_unitario, 2) }}€

        @if ($unidad->extras->isNotEmpty())
            <ul class="ml-4 text-sm text-gray-300">
                @foreach ($unidad->extras as $extra)
                    <li>
                        {{ $extra->nombre }} x {{ $extra->pivot->cantidad }} =
                        {{ number_format($extra->precio * $extra->pivot->cantidad, 2) }}€
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endforeach
<h3>Total: {{ number_format($precioTotal, 2) }}€</h3>

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
