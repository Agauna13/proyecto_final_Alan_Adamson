@extends('backend.layout')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-8 space-y-8">
        <!-- Cliente -->
        <section class="border border-gray-300 rounded-lg p-6 bg-gray-50">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A4.992 4.992 0 0112 15a4.992 4.992 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Cliente
            </h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-gray-700">
                <div>
                    <dt class="font-semibold">Nombre</dt>
                    <dd>{{ $reserva->cliente->nombre }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Teléfono</dt>
                    <dd>{{ $reserva->cliente->telefono }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Email</dt>
                    <dd>{{ $reserva->cliente->email }}</dd>
                </div>
            </dl>
        </section>

        <!-- Datos de la Reserva -->
        <section class="border border-gray-300 rounded-lg p-6 bg-gray-50">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-7H3v7a2 2 0 002 2z" />
                </svg>
                Datos de la Reserva
            </h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-gray-700">
                <div>
                    <dt class="font-semibold">Número de personas</dt>
                    <dd>{{ $reserva->pax }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Fecha</dt>
                    <dd>{{ $reserva->fecha }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Hora</dt>
                    <dd>{{ $reserva->hora }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Pedido</dt>
                    @if ($reserva->pedidos)
                        <dd>
                            <a href="{{ route('admin.pedidos.show', $reserva->pedidos) }}"
                                class="text-blue-600 hover:underline font-medium">
                                Ver pedido #{{ $reserva->pedidos->id }}
                            </a>
                        </dd>
                    @else
                        <dd class="italic text-gray-400">Sin pedido</dd>
                    @endif
                </div>
            </dl>

            <!-- Comentario del cliente -->
            <div class="mt-6 p-4 bg-gray-100 rounded-md border border-gray-300">
                <dt class="font-semibold text-gray-800 mb-2">Comentario del cliente</dt>
                @if ($reserva->comentarios)
                    <dd class="text-gray-700">{{ $reserva->comentarios }}</dd>
                @else
                    <dd class="italic text-gray-400">Sin mensajes del cliente</dd>
                @endif
            </div>
        </section>

        <!-- Acciones -->
        <section class="flex flex-col sm:flex-row justify-end gap-4">
            <form action="{{ route('admin.reservas.destroy', $reserva->id) }}" method="POST"
                onsubmit="return confirm('¿Estás seguro de que quieres borrar esta reserva?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full sm:w-auto px-5 py-2 bg-red-600 text-white rounded shadow hover:bg-red-700 transition font-semibold">
                    Borrar Reserva
                </button>
            </form>

            <a href="{{ route('admin.reservas.edit', $reserva) }}"
                class="w-full sm:w-auto px-5 py-2 bg-gray-800 text-white rounded shadow hover:bg-gray-900 transition font-semibold text-center">
                Editar Reserva
            </a>
        </section>
    </div>
@endsection
