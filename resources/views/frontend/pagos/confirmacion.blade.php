@extends('frontend.layout')

@section('content')
<div class="p-6 text-white">
<h2>Pedido #{{ $pedido->id }}</h2>

<h3>Productos</h3>
@foreach ($pedido->pedidoProductos as $unidad)
    <div>
        <strong>{{ $unidad->producto->nombre }}</strong> - {{ $unidad->precio_unitario }}€

        @if ($unidad->extras->isNotEmpty())
            <ul>
                @foreach ($unidad->extras as $extra)
                    <li>{{ $extra->nombre }} x {{ $extra->pivot->cantidad }} = {{$extra->precio}}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endforeach

<h3>Total: {{ number_format($precioTotal, 2) }}</h3>

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
