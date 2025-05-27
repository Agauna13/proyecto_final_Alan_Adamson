@extends('frontend.layout')

@section('content')
<section class="bg-gradient-to-b from-black via-gray-900 to-black min-h-screen px-6 py-10 text-white font-sans relative overflow-hidden">

    <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-bold mb-3 animate-pulse text-white">
            Resumen de tu Pedido
        </h1>
        @if ($pedido->reserva)
            <p class="text-gray-300 text-lg sm:text-xl">Gracias por tu reserva {{ $pedido->reserva->cliente->nombre }}</p>
            <p class="text-gray-300 text-lg sm:text-xl">{{ $pedido->reserva->cliente->nombre }}</p>
            <p class="text-gray-300 text-lg sm:text-xl">Te esperamos el {{ $pedido->reserva->fecha }} a las {{ $pedido->reserva->hora }}h</p>
            <p class="text-gray-300 text-lg sm:text-xl">Tu número de <strong>reserva</strong> es el #{{ $pedido->reserva->id }}</p>

        @else
            <p class="text-gray-300 text-lg sm:text-xl">Gracias por su pedido</p>
            <p class="text-gray-300 text-lg sm:text-xl">Su número identificador de pedido es el <strong class="text-red-600">#{{ $pedido->id }}</strong></p>
            <p class="text-gray-300 text-lg sm:text-xl">Lo ponemos en marcha y lo tendrá a la mayor brevedad posible</p>
        @endif
    </div>

    <div class="max-w-4xl mx-auto bg-gray-900/80 rounded-xl shadow-lg p-6 space-y-8">
        <div class="border-b border-red-700 pb-4">
            <h2 class="text-2xl font-bold text-red-600">Pedido #{{ $pedido->id }}</h2>
        </div>

        <div class="space-y-4">
            @foreach ($pedido->pedidoProductos as $unidad)
                <div class="bg-gray-800/70 border border-red-700/50 rounded-lg p-4 shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-semibold text-white">
                            {{ $unidad->producto->nombre }}
                        </div>
                        <div class="text-red-600 font-bold">
                            {{ number_format($unidad->precio_unitario, 2) }} €
                        </div>
                    </div>

                    @if ($unidad->extras->isNotEmpty())
                        <div class="mt-2">
                            <h4 class="text-sm font-medium text-red-500 mb-1">Extras:</h4>
                            <ul class="ml-4 list-disc text-sm text-gray-300 space-y-1">
                                @foreach ($unidad->extras as $extra)
                                    <li>
                                        {{ $extra->nombre }} × {{ $extra->pivot->cantidad }}
                                        = <span class="text-red-500">{{ number_format($extra->precio * $extra->pivot->cantidad, 2) }} €</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="border-t border-red-700 pt-4 flex justify-end">
            <h3 class="text-xl font-bold text-red-600">Total: {{ number_format($precioTotal, 2) }} €</h3>
        </div>
    </div>

    @if (session('error'))
        <div class="mt-6 max-w-3xl mx-auto bg-red-900/90 text-red-300 rounded-xl p-4 shadow-md">
            <p class="font-semibold">⚠️ {{ session('error') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mt-6 max-w-3xl mx-auto bg-red-900/90 text-red-300 rounded-xl p-4 shadow-md">
            <ul class="list-disc ml-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</section>
@endsection
