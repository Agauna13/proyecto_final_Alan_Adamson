@extends('backend.layout')

@section('content')
    <div class="flex flex-col min-h-screen bg-white rounded-2xl shadow-lg border border-gray-200">
        <h1 class="text-3xl font-extrabold text-indigo-700 tracking-wide mb-6 p-6 text-center">Panel de Administración</h1>

        <div class="flex-1 flex items-center justify-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full max-w-3xl p-6">
                {{-- Pedidos --}}
                <a href="{{ route('admin.pedidos.index') }}"
                    class="flex flex-col items-center justify-center p-6 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition min-h-[150px]">
                    <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    <span class="text-lg font-semibold">Pedidos</span>
                </a>

                {{-- Reservas --}}
                <a href="{{ route('admin.reservas.index') }}"
                    class="flex flex-col items-center justify-center p-6 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition min-h-[150px]">
                    <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3M4 11h16M4 19h16M4 15h16" />
                    </svg>
                    <span class="text-lg font-semibold">Reservas</span>
                </a>

                {{-- Mesas --}}
                <a href="{{ route('admin.mesas.index') }}"
                    class="flex flex-col items-center justify-center p-6 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition min-h-[150px]">
                    <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M3 10h18M4 14h16M5 18h14" />
                    </svg>
                    <span class="text-lg font-semibold">Mesas</span>
                </a>

                {{-- Clientes --}}
                <a href="{{ route('admin.clientes.index') }}"
                    class="flex flex-col items-center justify-center p-6 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition min-h-[150px]">
                    <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zM12 14c-4 0-8 2-8 6v2h16v-2c0-4-4-6-8-6z" />
                    </svg>
                    <span class="text-lg font-semibold">Clientes</span>
                </a>
            </div>
        </div>
    </div>
@endsection
