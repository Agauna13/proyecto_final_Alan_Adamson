@extends('frontend.layout')

@section('content')
<form method="GET" action="{{ route('pedidos.create') }}" class="flex flex-col gap-6 bg-black px-5 text-white">
    @csrf
    @foreach ($productos->groupBy('grupo') as $grupo => $productosPorGrupo)
        <h2 class="mx-40 text-[32px]">{{ ucfirst($grupo) }}</h2>

        @foreach ($productosPorGrupo->groupBy('categoria') as $categoria => $productosPorCategoria)
            <h3 class="text-[24px]">{{ ucfirst($categoria) }}</h3>

            <div id="{{ $productosPorCategoria->first()->css_id }}">
                @foreach ($productosPorCategoria as $producto)
                    <div class="flex flex-row items-center justify-between">
                        <label>
                            {{ $producto->nombre }} ({{ $producto->precio }}€)
                            <input type="number" name="cantidad[{{ $producto->id }}]" min="0" placeholder="0" class="w-16 text-black">
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endforeach

    <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
        Hacer Pedido
    </button>
</form>
@endsection
