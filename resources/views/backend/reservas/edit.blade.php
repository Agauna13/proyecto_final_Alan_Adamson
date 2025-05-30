@extends('backend.layout')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-8 space-y-8">

    <h3 class="text-2xl font-bold text-red-600 mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4v16m8-8H4" />
        </svg>
        Editar Reserva
    </h3>

    <form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="nombre" class="block text-gray-700 font-semibold">Nombre</label>
                <input type="text" name="nombre" id="nombre"
                    value="{{ old('nombre', $reserva->cliente->nombre) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" />
            </div>

            <div>
                <label for="pax" class="block text-gray-700 font-semibold">Número de personas</label>
                <input type="number" name="pax" id="pax"
                    value="{{ old('pax', $reserva->pax) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" />
            </div>

            <div>
                <label for="fecha" class="block text-gray-700 font-semibold">Fecha</label>
                <input type="date" name="fecha" id="fecha"
                    value="{{ old('fecha', $reserva->fecha) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" />
            </div>

            <div>
                <label for="hora" class="block text-gray-700 font-semibold">Hora</label>
                <input type="time" name="hora" id="hora"
                    value="{{ old('hora', $reserva->hora) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" />
            </div>

            <div>
                <label for="sala_terraza" class="block text-gray-700 font-semibold">Ubicación</label>
                <select name="sala_terraza" id="sala_terraza"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                    <option value="sala" {{ old('sala_terraza', $reserva->sala_terraza) == 'sala' ? 'selected' : '' }}>
                        Sala</option>
                    <option value="terraza" {{ old('sala_terraza', $reserva->sala_terraza) == 'terraza' ? 'selected' : '' }}>
                        Terraza</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-red-600 text-white px-6 py-3 rounded shadow hover:bg-red-700 transition font-semibold">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection
