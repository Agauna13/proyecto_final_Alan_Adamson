@extends('backend.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <a href="{{ route('admin.reservas.index') }}" class="text-2xl sm:text-3xl font-extrabold text-indigo-700 tracking-wide">
                Reservas
            </a>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.reservas.create') }}"
                    class="inline-block px-4 py-2 text-sm sm:text-base bg-red-600 text-white rounded-lg shadow hover:bg-white hover:text-red-700 hover:font-bold hover:text-[22px] focus:ring-4 focus:ring-indigo-300 transition font-semibold">
                +
                </a>
                <a href="{{ route('admin.reservas.hoy') }}"
                    class="inline-block px-4 py-2 text-sm sm:text-base bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition font-semibold">
                    Hoy
                </a>
                <a href="{{ route('admin.reservas.semana') }}"
                    class="inline-block px-4 py-2 text-sm sm:text-base bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition font-semibold">
                    Ésta semana
                </a>
                <a href="{{ route('admin.reservas.index') }}"
                    class="inline-block px-4 py-2 text-sm sm:text-base bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition font-semibold">
                    Todas
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="p-3 rounded-md bg-green-100 border border-green-300 text-green-800 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-3 rounded-md bg-red-50 border border-red-300 text-red-700 shadow-sm">
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-100 text-indigo-900 uppercase text-xs sm:text-sm font-semibold tracking-wide">
                    <tr>
                        <th class="px-4 py-3 text-left">Cliente</th>
                        <th class="px-4 py-3 text-left">Personas</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Hora</th>
                        <th class="px-4 py-3 text-left">Pedido</th>
                        <th class="px-4 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700 text-sm sm:text-base">
                    @forelse ($reservas as $reserva)
                        <tr class="hover:bg-indigo-50 transition-colors">
                            <td class="px-4 py-3 font-medium uppercase">{{ $reserva->cliente->nombre }}</td>
                            <td class="px-4 py-3 font-bold">{{ $reserva->pax }}</td>
                            <td class="px-4 py-3 capitalize">{{ $reserva->fecha_formateada }}</td>
                            <td class="px-4 py-3">{{ $reserva->hora_formateada }}</td>
                            <td class="px-4 py-3">
                                @if ($reserva->pedidos)
                                    <a href="{{ route('admin.pedidos.show', $reserva->pedidos) }}"
                                        class="inline-block px-3 py-1 text-xs sm:text-sm bg-green-600 text-white rounded shadow hover:bg-green-700 transition font-semibold">
                                        Ver pedido #{{ $reserva->pedidos->id }}
                                    </a>
                                @else
                                    <span class="italic text-gray-400">Sin pedido</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.reservas.show', $reserva->id) }}"
                                    class="inline-block px-3 py-1 text-xs sm:text-sm bg-indigo-700 text-white rounded shadow hover:bg-indigo-900 transition font-semibold">
                                    Ver Reserva
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500 italic">No hay reservas para mostrar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
