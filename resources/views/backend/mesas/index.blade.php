@extends('backend.layout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl text-white p-8 mb-10 shadow-md text-center">
        <h1 class="text-4xl font-extrabold mb-3">Plano de Mesas</h1>
        <p class="text-lg mb-6">Consulta el estado de cada mesa y accede a sus pedidos rápidamente.</p>

        <a href="{{ route('admin.mesasOcupadas') }}"
            class="inline-block px-6 py-3 bg-white text-indigo-600 font-semibold rounded-full shadow-lg hover:bg-gray-100 transition-all duration-300">
            Ver solo mesas ocupadas
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
        @foreach ($mesas as $mesa)
            @if($mesa->estado === 'ocupada')
                <div
                    class="bg-white rounded-2xl shadow-lg p-4 flex flex-col items-center justify-between text-center hover:shadow-xl transition-shadow duration-300 border-t-4 border-red-600">
                    <div class="flex flex-col items-center gap-2">
                        <div class="text-4xl">🪑</div>
                        <h2 class="text-lg font-semibold">Mesa #{{ $mesa->id }}</h2>
                    </div>

                    @if ($mesa->pedidos->isNotEmpty())
                        <a href="{{ route('admin.pedidos.show', $mesa->pedidos->first()->id) }}"
                            class="mt-4 inline-block text-sm px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Ver Pedido #{{ $mesa->pedidos->first()->id }}
                        </a>
                    @else
                        <span class="mt-4 inline-block text-sm px-3 py-1 bg-gray-200 text-gray-600 rounded-full">
                            Sin pedidos
                        </span>
                    @endif
                </div>
            @else
                <div
                    class="bg-white rounded-2xl shadow-lg p-4 flex flex-col items-center justify-between text-center hover:shadow-xl transition-shadow duration-300 border-t-4 border-green-500">
                    <div class="flex flex-col items-center gap-2">
                        <div class="text-4xl">🪑</div>
                        <h2 class="text-lg font-semibold">Mesa #{{ $mesa->id }}</h2>
                    </div>

                    @if ($mesa->pedidos->isNotEmpty())
                        <a href="{{ route('admin.pedidos.show', $mesa->pedidos->first()) }}"
                            class="mt-4 inline-block text-sm px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Ver Pedido #{{ $mesa->pedidos->first()->id }}
                        </a>
                    @else
                        <span class="mt-4 inline-block text-sm px-3 py-1 bg-gray-200 text-gray-600 rounded-full">
                            Sin pedidos
                        </span>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
