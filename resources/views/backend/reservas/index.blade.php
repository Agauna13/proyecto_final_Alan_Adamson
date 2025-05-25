@extends('backend.layout')

@section('content')
    <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg border border-gray-200 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-indigo-700 tracking-wide">Reservas</h2>
            <a href="{{ route('admin.reservas.create') }}"
                class="px-4 py-2 text-sm sm:text-base bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition font-semibold">
                Nueva Reserva
            </a>
        </div>

        @if (session('success'))
            <p class="text-green-700 bg-green-100 border border-green-300 rounded-lg p-3 mb-4 shadow-sm">
                {{ session('success') }}
            </p>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-300 text-red-700 rounded-lg shadow-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-x-auto rounded border border-gray-300 shadow-sm">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-indigo-100 sticky top-0">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left font-semibold text-indigo-900 uppercase tracking-wider">
                            Cliente</th>
                        <th class="px-4 sm:px-6 py-3 text-left font-semibold text-indigo-900 uppercase tracking-wider">
                            Personas</th>
                        <th class="px-4 sm:px-6 py-3 text-left font-semibold text-indigo-900 uppercase tracking-wider">
                            Fecha</th>
                        <th class="px-4 sm:px-6 py-3 text-left font-semibold text-indigo-900 uppercase tracking-wider">
                            Hora</th>
                        <th class="px-4 sm:px-6 py-3 text-left font-semibold text-indigo-900 uppercase tracking-wider">
                            Pedido</th>
                        <th class="px-4 sm:px-6 py-3 text-left font-semibold text-indigo-900 uppercase tracking-wider">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($reservas as $reserva)
                        <tr class="hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-4 sm:px-6 py-3 font-medium uppercase">{{ $reserva->cliente->nombre }}</td>
                            <td class="px-4 sm:px-6 py-3 font-bold">{{ $reserva->pax }}</td>
                            <td class="px-4 sm:px-6 py-3 capitalize">{{ $reserva->fecha_formateada }}</td>
                            <td class="px-4 sm:px-6 py-3">{{ $reserva->hora_formateada }}</td>
                            <td class="px-4 sm:px-6 py-3">
                                @if ($reserva->pedidos)
                                    <a href="{{ route('admin.pedidos.show', $reserva->pedidos) }}"
                                        class="inline-block px-3 py-1 text-xs sm:text-sm bg-green-700 text-white rounded shadow hover:bg-gray-900 transition font-semibold">
                                        Ver pedido #{{ $reserva->pedidos->id }}
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Sin pedido</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-3">
                                <a href="{{ route('admin.reservas.show', $reserva->id) }}"
                                    class="inline-block px-3 py-1 text-xs sm:text-sm bg-indigo-700 text-white rounded shadow hover:bg-gray-900 transition font-semibold">
                                    Ver Reserva
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
