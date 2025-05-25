@extends('frontend.layout')

@section('content')
<section class="bg-gradient-to-b from-black via-gray-900 to-black min-h-screen px-6 pt-10 pb-24 text-white font-sans relative overflow-hidden">

    <div class="text-center mb-10">
        <h1 class="text-3xl sm:text-4xl font-bold text-yellow-400 mb-3 animate-pulse">Elige tus productos</h1>
        <p class="text-gray-300 text-lg sm:text-xl">Los extras se añaden en el siguiente paso</p>
    </div>

    <div class="flex justify-center my-6">
        <div class="w-16 h-1 bg-yellow-400 rounded-full animate-bounce"></div>
    </div>

    <form method="POST" action="{{ route('pedidos.redirectToPedido') }}" class="max-w-5xl mx-auto relative" id="form-productos">
        @csrf

        <div class="space-y-12 pb-32">
            @foreach ($productos->groupBy('grupo') as $grupo => $productosPorGrupo)
                <div class="mb-8">
                    <h2 class="text-3xl font-black text-yellow-400 uppercase tracking-wider mb-6 drop-shadow-lg text-center animate-fade-in-down">
                        {{ ucfirst($grupo) }}
                    </h2>

                    @foreach ($productosPorGrupo->groupBy('categoria') as $categoria => $productosPorCategoria)
                        <div class="mb-10">
                            <h3 class="text-xl sm:text-2xl font-semibold border-b-2 border-yellow-400 pb-2 mb-5 uppercase tracking-wide flex items-center gap-2">
                                <span class="inline-block w-3 h-3 bg-yellow-400 rounded-full motion-safe:animate-bounce"></span>
                                {{ ucfirst($categoria) }}
                            </h3>

                            <div id="{{ $productosPorCategoria->first()->css_id }}" class="space-y-4">
                                @foreach ($productosPorCategoria as $producto)
                                    <div
                                        class="bg-gray-800/60 border border-yellow-500/30 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between shadow-md hover:shadow-yellow-400/20 transition"
                                    >
                                        <div class="text-lg font-medium mb-2 sm:mb-0">
                                            {{ $producto->nombre }} <span class="text-yellow-400 font-bold">({{ $producto->precio }}€)</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="decrease px-3 py-1 bg-yellow-500 text-black font-bold rounded-l hover:bg-yellow-400">−</button>
                                            <input
                                                type="number"
                                                name="cantidad[{{ $producto->id }}]"
                                                min="0"
                                                value="0"
                                                inputmode="numeric"
                                                pattern="[0-9]*"
                                                data-precio="{{ $producto->precio }}"
                                                class="cantidad-input w-14 sm:w-16 text-center text-black font-semibold rounded-none"
                                            >
                                            <button type="button" class="increase px-3 py-1 bg-yellow-500 text-black font-bold rounded-r hover:bg-yellow-400">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        {{-- Botón fijo dentro del formulario --}}
        <div class="fixed bottom-0 left-0 w-full bg-black bg-opacity-90 py-4 flex justify-center items-center shadow-lg z-50 gap-6">
            <div id="precioTotalFooter" class="text-center text-yellow-400 font-bold text-xl m-6">
                Total: 0.00 €
            </div>
            <button type="submit" class=" bg-green-600 hover:bg-green-500 transition px-6 py-3 rounded-xl text-xl font-semibold shadow-lg">
                Hacer Pedido
            </button>
        </div>
    </form>
</section>

@vite('resources/js/inputCounterOne.js')
@endsection
