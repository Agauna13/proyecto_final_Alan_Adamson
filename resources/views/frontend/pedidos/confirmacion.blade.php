@extends('frontend.layout')

@section('content')
<section
    class="bg-gradient-to-b from-black via-gray-900 to-black min-h-screen px-6 py-10 text-white font-sans relative overflow-hidden pb-28">

    <div class="max-w-3xl mx-auto mb-10 text-center animate-fade-in-down">
        <h2 class="text-3xl font-bold mb-2">Elige tus extras y entrantes</h2>
        <p class="text-gray-400 text-sm">Confirma tu pedido. Puedes añadir extras o entrantes opcionales antes de finalizar.</p>
    </div>

    @if ($reservaData || $mesa)
        <div
            class="max-w-3xl mx-auto mb-6 text-sm text-gray-300 bg-gray-800/40 p-4 rounded shadow border border-red-700/30">
            @if ($reservaData)
                <p><strong>Reserva:</strong> {{ $reservaData['nombre'] }} — {{ $reservaData['fecha'] }} a las {{ $reservaData['hora'] }}</p>
            @endif
            @if ($mesa)
                <p><strong>Mesa:</strong> {{ $mesa->id }}</p>
            @endif
        </div>
    @endif

    <form action="{{ route('pedidos.store') }}" method="POST" class="max-w-3xl mx-auto space-y-8 animate-fade-in pb-28" id="pedidoForm">
        @csrf

        <div>
            <h3 class="text-2xl font-semibold mb-4">Productos seleccionados</h3>
            @foreach ($productosUnicos as $index => $producto)
                <div class="bg-gray-900 border border-red-700/50 rounded-xl p-4 mb-6 shadow hover:shadow-red-700/50 transition">
                    <input type="hidden" name="productos[{{ $index }}][producto_id]" value="{{ $producto->id }}">
                    <input type="hidden" name="productos[{{ $index }}][precio_unitario]" value="{{ $producto->precio }}" class="precio-unitario" data-precio="{{ $producto->precio }}">

                    <div class="flex justify-between items-center">
                        <p class="text-lg font-semibold text-white">{{ $producto->nombre }}</p>
                        <span class="font-bold text-white">{{ number_format($producto->precio, 2) }} €</span>
                    </div>

                    @if ($producto->extras->isNotEmpty())
                        <div class="mt-4">
                            <p class="text-sm italic text-gray-400 mb-2">Selecciona extras por unidad:</p>

                            @if ($producto->categoria === 'Licores')
                                <div class="relative mt-2">
                                    <select name="productos[{{ $index }}][extra_licor]" class="block w-full rounded-md border border-red-600 bg-gray-900 text-white shadow-sm focus:border-red-600 focus:ring focus:ring-red-600/50">
                                        <option value="" class="text-black">Sin extra</option>
                                        @foreach ($producto->extras as $extra)
                                            <option value="{{ $extra->id }}" class="text-black">{{ $extra->nombre }} (+{{ number_format($extra->precio, 2) }} €)</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach ($producto->extras as $extra)
                                        <div class="flex items-center justify-between bg-gray-800 rounded px-3 py-2 border border-red-700/30">
                                            <label class="text-sm text-white">{{ $extra->nombre }} (+{{ number_format($extra->precio, 2) }} €)</label>
                                            <div class="flex items-center gap-2">
                                                <button type="button" class="decrease px-3 py-1 bg-red-600 text-white font-bold rounded-l hover:bg-red-700 transition">−</button>
                                                <input type="number" name="productos[{{ $index }}][extras_por_unidad][{{ $extra->id }}]" min="0" value="0" data-precio="{{ $extra->precio }}" class="cantidad-input w-14 sm:w-16 text-center text-black font-semibold rounded-none">
                                                <button type="button" class="increase px-3 py-1 bg-red-600 text-white font-bold rounded-r hover:bg-red-700 transition">+</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="ml-1 mt-2 text-sm italic text-gray-500">Sin extras disponibles</p>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($entrantes->isNotEmpty())
            <div>
                <h3 class="text-2xl font-semibold mb-4">Entrantes opcionales</h3>
                <div class="space-y-4">
                    @foreach ($entrantes as $entrante)
                        <div class="flex items-center justify-between bg-gray-800 rounded border border-red-700/30 px-4 py-2">
                            <label class="text-sm text-white">{{ $entrante->nombre }} ({{ number_format($entrante->precio, 2) }} €)</label>
                            <div class="flex items-center gap-2">
                                <button type="button" class="decrease px-3 py-1 bg-red-600 text-white font-bold rounded-l hover:bg-red-700 transition">−</button>
                                <input type="number" name="extras_entrantes[{{ $entrante->id }}]" min="0" value="0" data-precio="{{ $entrante->precio }}" class="cantidad-input w-14 sm:w-16 text-center text-black font-semibold rounded-none">
                                <button type="button" class="increase px-3 py-1 bg-red-600 text-white font-bold rounded-r hover:bg-red-700 transition">+</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </form>

</section>

<footer
    class="fixed bottom-0 left-0 right-0 bg-black/90 backdrop-blur-md border-t border-red-700/60 px-4 py-4 shadow-lg z-50">
    <div class="w-full max-w-5xl mx-auto flex flex-wrap justify-center sm:justify-between items-center gap-4">

        <span class="text-white font-bold text-base sm:text-lg whitespace-nowrap min-w-[140px]" id="precioTotalFooter">
            Total: 0.00 €
        </span>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}"
                class="bg-red-600 hover:bg-red-700 transition text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-sm sm:text-base font-semibold shadow">
                Cancelar
            </a>
            <button form="pedidoForm" type="submit"
                class="bg-green-600 hover:bg-green-500 transition duration- text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-sm sm:text-base font-semibold shadow">
                Confirmar Pedido
            </button>
        </div>

    </div>
</footer>
@vite('resources/js/inputCounterTwo.js')
@endsection
