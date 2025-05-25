@extends('backend.layout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-indigo-600 rounded-xl text-white p-4 mb-4 shadow flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="text-lg sm:text-xl font-semibold">Mesas</h1>
        <div class="flex flex-wrap gap-1 justify-center sm:justify-end">
            <a href="{{ route('admin.mesasOcupadas') }}"
                class="px-3 py-1 text-xs bg-white text-indigo-600 font-semibold rounded-full shadow hover:bg-gray-100 transition">Ocupadas</a>
            <a href="{{ route('admin.salaTerraza', 'sala') }}"
                class="px-3 py-1 text-xs bg-white text-indigo-600 font-semibold rounded-full shadow hover:bg-gray-100 transition">Sala</a>
            <a href="{{ route('admin.salaTerraza', 'terraza') }}"
                class="px-3 py-1 text-xs bg-white text-indigo-600 font-semibold rounded-full shadow hover:bg-gray-100 transition">Terraza</a>
            <a href="{{ route('admin.mesas.index') }}"
                class="px-3 py-1 text-xs bg-red-700 text-white font-semibold rounded-full shadow hover:bg-white hover:text-red-700 transition">Todas</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @if ($mesas_sala && $mesas_sala->count())
        <div>
            <h2 class="text-lg font-bold text-indigo-700 mb-3">Sala</h2>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($mesas_sala as $mesa)
                    <div class="bg-white rounded-lg shadow p-2 flex flex-col items-center text-center border-l-4 {{ $mesa->estado === 'ocupada' ? 'border-red-600' : 'border-green-500' }} hover:shadow-md transition">
                        <div class="text-2xl">🪑</div>
                        <h3 class="text-xs font-semibold mt-1">Mesa #{{ $mesa->id }}</h3>
                        <p class="text-[10px] {{ $mesa->estado === 'ocupada' ? 'text-red-400' : 'text-green-600' }}">{{ ucfirst($mesa->estado) }}</p>
                        <div class="mt-1 flex flex-col gap-1 w-full">
                            <a href="{{ route('admin.mesas.show', $mesa) }}"
                                class="text-[10px] px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Detalles</a>
                            @if ($mesa->estado === 'ocupada')
                                <form action="{{ route('admin.mesas.liberar', $mesa->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres liberar esta mesa?')">
                                    @csrf
                                    <button type="submit" class="text-[10px] px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Liberar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Terraza --}}
        @if ($mesas_terraza && $mesas_terraza->count())
        <div>
            <h2 class="text-lg font-bold text-indigo-700 mb-3">Terraza</h2>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($mesas_terraza as $mesa)
                    <div class="bg-white rounded-lg shadow p-2 flex flex-col items-center text-center border-l-4 {{ $mesa->estado === 'ocupada' ? 'border-red-600' : 'border-green-500' }} hover:shadow-md transition">
                        <div class="text-2xl">🪑</div>
                        <h3 class="text-xs font-semibold mt-1">Mesa #{{ $mesa->id }}</h3>
                        <p class="text-[10px] {{ $mesa->estado === 'ocupada' ? 'text-red-400' : 'text-green-600' }}">{{ ucfirst($mesa->estado) }}</p>
                        <div class="mt-1 flex flex-col gap-1 w-full">
                            <a href="{{ route('admin.mesas.show', $mesa) }}"
                                class="text-[10px] px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Detalles</a>
                            @if ($mesa->estado === 'ocupada')
                                <form action="{{ route('admin.mesas.liberar', $mesa->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres liberar esta mesa?')">
                                    @csrf
                                    <button type="submit" class="text-[10px] px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Liberar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @if ((!$mesas_sala || $mesas_sala->isEmpty()) && (!$mesas_terraza || $mesas_terraza->isEmpty()))
        <p class="text-center text-xs text-gray-500 mt-6">No hay mesas disponibles.</p>
    @endif

</div>
@endsection
