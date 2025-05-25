@extends('frontend.layout')

@section('content')
    <section class="bg-gradient-to-b from-black via-gray-900 to-black min-h-screen px-6 py-10 text-white font-sans relative overflow-hidden">
        <!-- Separador inicial decorativo -->
        <div class="flex justify-center my-8">
            <div class="w-16 h-1 bg-yellow-400 rounded-full animate-bounce"></div>
        </div>

        @foreach ($productos->groupBy('grupo') as $grupo => $productosPorGrupo)
            <h2 class="text-4xl font-black text-center text-yellow-400 uppercase tracking-wider mb-10 drop-shadow-lg animate-pulse">
                {{ ucfirst($grupo) }}
            </h2>

            @foreach ($productosPorGrupo->groupBy('categoria') as $categoria => $productosPorCategoria)
                <div class="my-12">
                    <h3 class="text-2xl font-semibold border-b-2 border-yellow-400 pb-3 mb-6 uppercase tracking-wide flex items-center gap-2">
                        <span class="inline-block w-3 h-3 bg-yellow-400 rounded-full motion-safe:animate-bounce"></span>
                        {{ ucfirst($categoria) }}
                    </h3>

                    <div id="{{ $productosPorCategoria->first()->css_id }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($productosPorCategoria as $producto)
                            <div class="bg-gray-800/50 hover:bg-gray-800/80 border border-yellow-500/40 rounded-xl p-6 flex flex-col justify-between shadow-2xl hover:shadow-yellow-400/30 transition duration-300 transform hover:-translate-y-2">
                                <p class="font-semibold text-lg tracking-wide">{{ $producto->nombre }}</p>
                                <p class="text-yellow-400 font-extrabold text-right text-xl">{{ $producto->precio }}€</p>
                            </div>
                        @endforeach
                    </div>

                    @if ($productosPorCategoria->pluck('extras')->flatten()->isNotEmpty())
                        <div class="mt-6 pl-4 border-l-4 border-yellow-400 bg-gray-800/40 rounded shadow-inner animate-fade-in">
                            <h4 class="text-yellow-400 font-semibold mb-3 uppercase tracking-wide flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L15 8l6 1-4.5 4.4 1 6L12 16l-5.5 3 1-6L4 9l6-1z" /></svg>
                                Extras
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($productosPorCategoria->pluck('extras')->flatten()->unique('id') as $extra)
                                    <div class="flex justify-between items-center text-sm text-gray-200 bg-gray-700/60 rounded p-2 border border-yellow-500/20 shadow">
                                        <p>{{ $extra->nombre }}</p>
                                        <p class="text-yellow-300 font-bold">{{ $extra->precio }}€</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endforeach

        <!-- Separador final decorativo -->
        <div class="flex justify-center my-10">
            <div class="w-16 h-1 bg-yellow-400 rounded-full animate-pulse"></div>
        </div>
    </section>
@endsection
