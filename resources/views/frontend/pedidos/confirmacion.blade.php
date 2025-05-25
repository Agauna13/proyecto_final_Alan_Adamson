@extends('frontend.layout')

@section('content')
<section
    class="bg-gradient-to-b from-black via-gray-900 to-black min-h-screen px-6 py-10 text-white font-sans relative overflow-hidden pb-28"> {{-- pb-28 para espacio al footer --}}

    <!-- Mensaje introductorio -->
    <div class="max-w-3xl mx-auto mb-10 text-center animate-fade-in-down">
        <h2 class="text-3xl font-bold text-yellow-400 mb-2">Elige tus extras y entrantes</h2>
        <p class="text-gray-300 text-sm">Confirma tu pedido. Puedes añadir extras o entrantes opcionales antes de finalizar.</p>
    </div>

    @if ($reservaData || $mesa)
        <div class="max-w-3xl mx-auto mb-6 text-sm text-gray-300 bg-gray-800/40 p-4 rounded shadow border border-yellow-400/20">
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

        <!-- Productos seleccionados -->
        <div>
            <h3 class="text-2xl font-semibold text-yellow-400 mb-4">Productos seleccionados</h3>
            @foreach ($productosUnicos as $index => $producto)
                <div class="bg-gray-800/60 border border-yellow-500/30 rounded-xl p-4 mb-6 shadow hover:shadow-yellow-400/20 transition">
                    <input type="hidden" name="productos[{{ $index }}][producto_id]" value="{{ $producto->id }}">
                    <input type="hidden" name="productos[{{ $index }}][precio_unitario]" value="{{ $producto->precio }}" class="precio-unitario" data-precio="{{ $producto->precio }}">

                    <div class="flex justify-between items-center">
                        <p class="text-lg font-semibold">{{ $producto->nombre }}</p>
                        <span class="text-yellow-300 font-bold">{{ number_format($producto->precio, 2) }} €</span>
                    </div>

                    @if ($producto->extras->isNotEmpty())
                        <div class="mt-4">
                            <p class="text-sm italic text-gray-300 mb-2">Selecciona extras por unidad:</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach ($producto->extras as $extra)
                                    <div class="flex items-center justify-between bg-gray-700/60 rounded px-3 py-2 border border-yellow-500/10">
                                        <label class="text-sm text-gray-200">{{ $extra->nombre }} (+{{ number_format($extra->precio, 2) }} €)</label>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="decrease px-3 py-1 bg-yellow-500 text-black font-bold rounded-l hover:bg-yellow-400">−</button>
                                            <input type="number"
                                                name="productos[{{ $index }}][extras_por_unidad][{{ $extra->id }}]"
                                                min="0" value="0"
                                                data-precio="{{ $extra->precio }}"
                                                class="cantidad-input w-14 sm:w-16 text-center text-black font-semibold rounded-none">
                                            <button type="button" class="increase px-3 py-1 bg-yellow-500 text-black font-bold rounded-r hover:bg-yellow-400">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="ml-1 mt-2 text-sm italic text-gray-400">Sin extras disponibles</p>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Entrantes opcionales -->
        @if ($entrantes->isNotEmpty())
            <div>
                <h3 class="text-2xl font-semibold text-yellow-400 mb-4">Entrantes opcionales</h3>
                <div class="space-y-4">
                    @foreach ($entrantes as $entrante)
                        <div class="flex items-center justify-between bg-gray-800/40 border border-yellow-500/10 rounded px-4 py-2">
                            <label class="text-sm text-gray-200">{{ $entrante->nombre }} ({{ number_format($entrante->precio, 2) }} €)</label>
                            <div class="flex items-center gap-2">
                                <button type="button" class="decrease px-3 py-1 bg-yellow-500 text-black font-bold rounded-l hover:bg-yellow-400">−</button>
                                <input type="number" name="extras_entrantes[{{ $entrante->id }}]" min="0" value="0" data-precio="{{ $entrante->precio }}" class="cantidad-input w-14 sm:w-16 text-center text-black font-semibold rounded-none">
                                <button type="button" class="increase px-3 py-1 bg-yellow-500 text-black font-bold rounded-r hover:bg-yellow-400">+</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- No mostrar total aquí ya que va en footer --}}
    </form>

</section>

<footer
    class="fixed bottom-0 left-0 right-0 bg-gray-900/90 backdrop-blur-md border-t border-yellow-500/50 px-6 py-4 flex justify-center shadow-lg z-50">
    <div class="w-full max-w-3xl flex justify-between items-center gap-4">
        <span class="text-green-400 font-bold text-lg whitespace-nowrap" id="precioTotalFooter">Total: 0.00 €</span>

        <button form="pedidoForm" type="submit"
            class="bg-green-600 hover:bg-green-700 transition text-white px-6 py-3 rounded-xl font-bold shadow-md hover:shadow-green-400/40">
            Confirmar Pedido
        </button>
    </div>
</footer>

@vite('resources/js/inputCounterTwo.js')
@endsection
