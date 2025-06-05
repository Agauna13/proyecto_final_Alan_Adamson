@extends('frontend.layout')

@section('content')
    <section
        class="bg-gradient-to-b from-black via-gray-900 to-black min-h-screen px-6 pt-10 pb-24 text-white font-sans relative overflow-hidden">

        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3 animate-pulse">Elige tus productos</h1>
            <p class="text-gray-400 text-lg sm:text-xl italic">Los extras se añaden en el siguiente paso</p>
        </div>

        <div class="flex justify-center my-6">
            <div class="w-16 h-1 bg-red-600 rounded-full animate-bounce"></div>
        </div>

        <form method="POST" action="{{ route('pedidos.redirectToPedido') }}" class="max-w-6xl mx-auto relative"
            id="form-productos">
            @csrf

            <div class="space-y-16 pb-32">
                @foreach ($productos->groupBy('grupo') as $grupo => $productosPorGrupo)
                    <div class="mb-8">
                        <h2
                            class="desplegable cursor-pointer text-3xl font-extrabold text-red-600 uppercase tracking-wider mb-8 drop-shadow-lg text-center animate-fade-in-down">
                            {{ ucfirst($grupo) }}
                        </h2>

                        <div class="grupo-contenido hidden">
                            @foreach ($productosPorGrupo->groupBy('categoria') as $categoria => $productosPorCategoria)
                                <div class="mb-12">
                                    <h3
                                        class="desplegable cursor-pointer text-2xl font-semibold border-b-2 border-red-600 pb-3 mb-8 uppercase tracking-wide flex items-center gap-3 text-white">
                                        <span
                                            class="inline-block w-4 h-4 bg-red-600 rounded-full motion-safe:animate-bounce"></span>
                                        {{ ucfirst($categoria) }}
                                    </h3>

                                    <div id="{{ $productosPorCategoria->first()->css_id }}"
                                        class="categoria-contenido grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                                        @foreach ($productosPorCategoria as $producto)
                                            <div
                                                class="bg-gray-900 border border-red-600/50 rounded-xl p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between shadow-md transition hover:shadow-red-600/40">
                                                <div class="text-lg font-medium mb-4 sm:mb-0 text-gray-100">
                                                    {{ $producto->nombre }}
                                                    <span
                                                        class="text-white font-semibold ml-1">({{ $producto->precio }}€)</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <button type="button"
                                                        class="decrease px-4 py-1 bg-gray-600 text-white font-bold rounded-l hover:bg-gray-500 transition">−</button>
                                                    <input type="number" name="cantidad[{{ $producto->id }}]"
                                                        min="0" value="0" inputmode="numeric" pattern="[0-9]*"
                                                        data-precio="{{ $producto->precio }}"
                                                        class="cantidad-input w-16 text-center text-black font-semibold rounded-none">
                                                    <button type="button"
                                                        class="increase px-4 py-1 bg-red-600 text-white font-bold rounded-r hover:bg-red-500 transition">+</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div
                class="fixed bottom-0 left-0 w-full bg-black/90 py-4 px-4 flex flex-wrap justify-center sm:justify-between items-center shadow-lg z-50 gap-4 sm:gap-8 border-t border-red-700/40">
                <div id="precioTotalFooter" class="text-center text-red-400 font-bold text-lg sm:text-xl min-w-[140px]">
                    Total: 0.00 €
                </div>
                <div class="flex flex-wrap justify-center gap-3">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-500 transition px-5 sm:px-8 py-2 sm:py-3 rounded-xl text-base sm:text-xl font-semibold shadow-lg">
                        Hacer Pedido
                    </button>
                    <a href="{{ route('home') }}"
                        class="bg-red-600 hover:bg-red-500 transition duration-200 px-5 sm:px-8 py-2 sm:py-3 rounded-xl text-base sm:text-xl font-semibold shadow-lg">
                        Cancelar Pedido
                    </a>
                </div>
            </div>
        </form>
    </section>
    @vite('resources/js/inputCounterOne.js')
@endsection
