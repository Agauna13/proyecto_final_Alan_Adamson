@extends('backend.layout')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado compacto --}}
    <div class="bg-indigo-600 rounded-xl text-white p-4 mb-4 shadow flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="text-lg sm:text-xl font-semibold">Nueva Reserva</h1>
        <a href="{{ route('admin.reservas.index') }}"
            class="px-3 py-1 text-xs bg-white text-indigo-600 font-semibold rounded-full shadow hover:bg-gray-100 transition">Volver a Reservas</a>
    </div>

    {{-- Mensajes de éxito y error --}}
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded text-xs shadow">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded text-xs shadow">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded text-xs shadow">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <div class="bg-white rounded-xl shadow p-4">
        <form method="POST" action="{{ route('admin.reservas.store') }}" class="grid grid-cols-1 gap-4">
            @csrf

            {{-- Nombre --}}
            <div>
                <label for="nombre" class="block text-xs font-semibold text-gray-600">Nombre del Cliente</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                    class="mt-1 block w-full rounded border-gray-300 text-xs focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Teléfono y Email --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <label for="telefono" class="block text-xs font-semibold text-gray-600">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                        class="mt-1 block w-full rounded border-gray-300 text-xs focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-600">Email</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                        class="mt-1 block w-full rounded border-gray-300 text-xs focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            {{-- Pax y Ubicación --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <label for="pax" class="block text-xs font-semibold text-gray-600">Número de Personas (Pax)</label>
                    <input type="number" name="pax" id="pax" min="1" value="{{ old('pax') }}"
                        class="mt-1 block w-full rounded border-gray-300 text-xs focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="sala_terraza" class="block text-xs font-semibold text-gray-600">Ubicación</label>
                    <select name="sala_terraza" id="sala_terraza"
                        class="mt-1 block w-full rounded border-gray-300 text-xs focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="sala" {{ old('sala_terraza') == 'sala' ? 'selected' : '' }}>Sala</option>
                        <option value="terraza" {{ old('sala_terraza') == 'terraza' ? 'selected' : '' }}>Terraza</option>
                    </select>
                </div>
            </div>

            {{-- Fecha y Hora --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <label for="fecha" class="block text-xs font-semibold text-gray-600">Fecha</label>
                    <input type="date" name="fecha" id="fecha" value="{{ old('fecha') }}"
                        class="mt-1 block w-full rounded border-gray-300 text-xs focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="hora" class="block text-xs font-semibold text-gray-600">Hora</label>
                    <input type="time" name="hora" id="hora" value="{{ old('hora') }}"
                        class="mt-1 block w-full rounded border-gray-300 text-xs focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            {{-- Botón --}}
            <div class="pt-2">
                <button type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded hover:bg-indigo-700 shadow transition">
                    Guardar Reserva
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
