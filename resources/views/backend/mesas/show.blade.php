@extends('backend.layout')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div
            class="bg-white rounded-2xl shadow-md p-6 mb-8 border-l-4 border-indigo-500 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-indigo-700 mb-2">Detalles de la Mesa #{{ $mesa->id }}</h1>
                <p class="text-gray-600">
                    Estado actual:
                    <span
                        class="font-semibold {{ $mesa->estado === 'ocupada' ? 'text-red-600' : 'text-green-600' }}">
                        {{ ucfirst($mesa->estado) }}
                    </span>
                </p>
            </div>

            @if($mesa->estado === 'ocupada')
            <form action="{{ route('admin.mesas.liberar', $mesa->id) }}" method="POST"
                onsubmit="return confirm('¿Seguro que quieres liberar esta mesa?')"
                class="self-start sm:self-auto">
                @csrf
                <button type="submit"
                    class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition font-semibold">
                    Liberar Mesa
                </button>
            </form>
            @else
            <form action="{{ route('admin.mesas.ocupar', $mesa->id) }}" method="POST"
                onsubmit="return confirm('¿Seguro que quieres marcar esta mesa com ocupada?')"
                class="self-start sm:self-auto">
                @csrf
                <button type="submit"
                    class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition font-semibold">
                    Marcar Como Ocupada
                </button>
            </form>
            @endif
        </div>

        {{-- Pedidos Pendientes --}}
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">🕒 Pedidos Pendientes</h2>

            @if ($pendientes->isEmpty())
                <div class="bg-yellow-100 text-yellow-800 rounded-xl p-4 shadow-sm">
                    No hay pedidos pendientes para esta mesa.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($pendientes as $pedido)
                        <div class="bg-white border-l-4 border-yellow-500 rounded-xl shadow-md p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Pedido #{{ $pedido->id }}</h3>
                            <p class="text-sm text-gray-600">Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                            <p class="text-sm text-gray-600 mb-3">Estado:
                                <span class="text-yellow-600 font-medium">Pendiente</span>
                            </p>
                            <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                                class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Ver Detalles
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Pedidos Servidos --}}
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">📅 Histórico de pedidos</h2>

            @if ($historico->isEmpty())
                <div class="bg-gray-100 text-gray-500 rounded-xl p-4 shadow-sm">
                    No hay pedidos servidos registrados para esta mesa.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($historico as $pedido)
                        <div class="bg-white border-l-4 border-green-500 rounded-xl shadow-md p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Pedido #{{ $pedido->id }}</h3>
                            <p class="text-sm text-gray-600">Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                            <p class="text-sm text-gray-600 mb-3">Estado:
                                <span class="text-gray-600 font-medium">{{$pedido->estado}}</span>
                            </p>
                            <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                                class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Ver Detalles
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
