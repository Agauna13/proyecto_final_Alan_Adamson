@extends('frontend.layout')

@section('content')
    <div class="flex flex-col gap-6 bg-black px-5">
        @foreach ($productos->groupBy('grupo') as $grupo => $productosPorGrupo)
            <h2 class="mx-40 text-[32px]">{{ ucfirst($grupo) }}</h2>
            <!-- Título para cada grupo (Comida o Bebida) -->

            @foreach ($productosPorGrupo->groupBy('categoria') as $categoria => $productosPorCategoria)
                <h3 class=" text-[24px]">{{ ucfirst($categoria) }}</h3>
                <!-- Título para cada categoría dentro del grupo -->
                <div id="{{ $productosPorCategoria->first()->css_id }}">
                    @foreach ($productosPorCategoria as $producto)
                        <div class = "flex flex-row items-center justify-between">
                            <p>{{ $producto->nombre }}</p>
                            <p>{{ $producto->precio }}€</p>
                        </div>
                    @endforeach
                </div>

                @if ($productosPorCategoria->pluck('extras')->flatten()->isNotEmpty())
                    <div class="mx-20">
                        <h4 class="text-white">Extras</h4>
                            @foreach ($productosPorCategoria->pluck('extras')->flatten()->unique('id') as $extra)
                                <div class = "flex flex-row items-center justify-between text-white">
                                    <p>{{ $extra->nombre }}</p>
                                    <p>{{ $extra->precio }}€</p> <!-- Mostrar extras únicos -->
                                </div>
                            @endforeach

                    </div>
                @endif
            @endforeach
        @endforeach
    </div>
@endsection
