@extends('frontend.layout')

@section('content')
<section class="bg-gradient-to-b from-black via-gray-900 to-black min-h-screen px-6 py-10 text-white font-sans relative overflow-hidden">

    <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-bold text-yellow-400 mb-3 animate-pulse">
            Resumen de tu Pedido
        </h1>
        @if ($pedido->reserva && $pedido->reserva->isNotEmpty())
        <p class="text-gray-300 text-lg sm:text-xl">Gracias por tu reserva {{ $pedido->reserva->cliente->nombre}}</p>
        <p class="text-gray-300 text-lg sm:text-xl">{{ $pedido->reserva->cliente->nombre}}</p>
        <p class="text-gray-300 text-lg sm:text-xl">Te esperamos el {{ $pedido->reserva->fecha }} a las {{ $pedido->reserva->hora}}h</p>
        @else
        <p class="text-gray-300 text-lg sm:text-xl">Gracias por su pedido</p>
        <p class="text-gray-300 text-lg sm:text-xl">Su numero identificador de pedido es el <strong class="text-green-700">#{{ $pedido->id}}</strong></p>
        <p class="text-gray-300 text-lg sm:text-xl">Lo ponemos en marcha y lo tendrá a la mayor brevedad posible</p>
        @endif
    </div>

    <div class="max-w-4xl mx-auto bg-gray-800/70 rounded-xl shadow-lg p-6 space-y-8">
        <div class="border-b border-yellow-500 pb-4">
            <h2 class="text-2xl font-bold text-yellow-400">Pedido #{{ $pedido->id }}</h2>
        </div>

        <div class="space-y-4">
            @foreach ($pedido->pedidoProductos as $unidad)
                <div class="bg-gray-900/60 border border-yellow-400/30 rounded-lg p-4 shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-semibold text-white">
                            {{ $unidad->producto->nombre }}
                        </div>
                        <div class="text-yellow-400 font-bold">
                            {{ number_format($unidad->precio_unitario, 2) }} €
                        </div>
                    </div>

                    @if ($unidad->extras->isNotEmpty())
                        <div class="mt-2">
                            <h4 class="text-sm font-medium text-yellow-300 mb-1">Extras:</h4>
                            <ul class="ml-4 list-disc text-sm text-gray-300 space-y-1">
                                @foreach ($unidad->extras as $extra)
                                    <li>
                                        {{ $extra->nombre }} × {{ $extra->pivot->cantidad }}
                                        = <span class="text-yellow-300">{{ number_format($extra->precio * $extra->pivot->cantidad, 2) }}€</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="border-t border-yellow-500 pt-4 flex justify-end">
            <h3 class="text-xl font-bold text-yellow-400">Total: {{ number_format($precioTotal, 2) }} €</h3>
        </div>
    </div>

    @if (session('error'))
        <div class="mt-6 max-w-3xl mx-auto bg-red-800/80 text-red-200 rounded-xl p-4 shadow-md">
            <p class="font-semibold">⚠️ {{ session('error') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mt-6 max-w-3xl mx-auto bg-red-800/80 text-red-200 rounded-xl p-4 shadow-md">
            <ul class="list-disc ml-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</section>
@endsection
