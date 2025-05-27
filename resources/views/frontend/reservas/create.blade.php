@extends('frontend.layout')

@section('content')

    <section class="bg-black text-white py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold mb-8">Haz tu reserva</h2>

            @if ($errors->any())
                <div class="mt-6 p-4 border border-red-500 bg-red-800/20 text-white rounded-md">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M5.6 18.4a9 9 0 1112.8 0L12 21l-6.4-2.6z" />
                        </svg>
                        <p class="font-semibold">Se encontraron algunos errores:</p>
                    </div>
                    <ul class="mt-2 pl-6 list-disc space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('reservas.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="nombre" class="block text-sm font-medium">Nombre Cliente</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required
                        class="mt-1 block w-full rounded-md bg-gray-800 text-white border border-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label for="telefono" class="block text-sm font-medium">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" required
                        class="mt-1 block w-full rounded-md bg-gray-800 text-white border border-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full rounded-md bg-gray-800 text-white border border-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label for="pax" class="block text-sm font-medium">Pax</label>
                    <input type="number" name="pax" value="{{ old('pax') }}" required
                        class="mt-1 block w-full rounded-md bg-gray-800 text-white border border-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label for="fecha" class="block text-sm font-medium">Fecha</label>
                    <input type="date" name="fecha" value="{{ old('fecha') }}" required
                        class="mt-1 block w-full rounded-md bg-gray-800 text-white border border-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label for="hora" class="block text-sm font-medium">Hora</label>
                    <input type="time" name="hora" value="{{ old('hora') }}" required
                        class="mt-1 block w-full rounded-md bg-gray-800 text-white border border-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label for="sala_terraza" class="block text-sm font-medium">Sala / Terraza</label>
                    <select name="sala_terraza"
                        class="mt-1 block w-full rounded-md bg-gray-800 text-white border border-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="sala">Sala</option>
                        <option value="terraza">Terraza</option>
                    </select>
                </div>

                <div>
                    <label for="comentarios" class="block text-sm font-medium">Comentarios</label>
                    <textarea name="comentarios" rows="3"
                        class="mt-1 block w-full rounded-md bg-gray-800 text-white border border-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('comentarios') }}</textarea>
                </div>


                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" name="action" value="guardar"
                        class="w-full sm:w-auto inline-block rounded-md bg-red-600 px-6 py-2.5 text-sm font-medium text-white transition hover:bg-white hover:text-red-600">
                        Enviar sin hacer Pedido
                    </button>

                    <button type="submit" name="action" value="pedido"
                        class="w-full sm:w-auto inline-block rounded-md bg-white text-red-600 px-6 py-2.5 text-sm font-medium transition hover:bg-red-600 hover:text-white">
                        Quiero pedir mi comida ahora
                    </button>
                </div>
            </form>

            @if (session('error'))
                <div class="mt-6 p-4 bg-red-800 text-red-200 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mt-6 p-4 bg-green-800 text-green-200 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 p-4 bg-red-900 text-red-200 rounded-md">
                    <ul class="list-disc pl-6 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>
@endsection
