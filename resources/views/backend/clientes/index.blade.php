@extends('backend.layout')

@section('content')
    <div class="p-6 bg-white rounded-2xl shadow-lg border border-gray-200 max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-indigo-700 tracking-wide mb-6">Clientes</h1>

        <div class="overflow-x-auto border border-gray-300 rounded-lg shadow-sm">
            <div class="overflow-y-auto max-h-[420px]">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                    <thead class="bg-indigo-100">
                        <tr>
                            <th class="sticky top-0 bg-indigo-100 px-6 py-3 text-left font-semibold text-indigo-900 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th class="sticky top-0 bg-indigo-100 px-6 py-3 text-left font-semibold text-indigo-900 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="sticky top-0 bg-indigo-100 px-6 py-3 text-left font-semibold text-indigo-900 uppercase tracking-wider">
                                Teléfono
                            </th>
                            <th class="sticky top-0 bg-indigo-100 px-6 py-3 text-left font-semibold text-indigo-900 uppercase tracking-wider">
                                Reservas
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($clientes as $cliente)
                            <tr class="hover:bg-indigo-50 transition-colors duration-200 cursor-pointer">
                                <td class="px-6 py-3 font-medium">{{ strtoupper($cliente->nombre) }}</td>
                                <td class="px-6 py-3">{{ $cliente->email ?? '—' }}</td>
                                <td class="px-6 py-3">{{ $cliente->telefono ?? '—' }}</td>
                                <td class="px-6 py-3 space-y-1">
                                    @forelse ($cliente->reservas as $reserva)
                                        <a href="{{ route('admin.reservas.show', $reserva->id) }}"
                                            class="inline-block px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition font-medium">
                                            Reserva #{{ $reserva->id }}
                                        </a>
                                    @empty
                                        <span class="text-gray-400 italic">Sin reservas</span>
                                    @endforelse
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
