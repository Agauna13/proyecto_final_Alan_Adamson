<div>
    @foreach ($reservas as $reserva)
        <p>Cliente: {{ $reserva->cliente->nombre }}</p>
        <p>Pax: {{ $reserva->pax }}</p>
        <p>fecha: {{ $reserva->fecha }}</p>
        <p>hora: {{ $reserva->hora }}</p>

        @if ($reserva->pedidos)
            <p>Pedido ID: {{ $reserva->pedidos->id }}</p>
            <p>Detalle: {{ $reserva->pedidos->detalle }}</p>
        @else
            <p><em>Sin pedido</em></p>
        @endif
        <a href="{{ route('admin.reservas.show', $reserva->id) }}">
            Ver
        </a>
        <hr>
    @endforeach

    <a href="{{ route('admin.reservas.create')}}">Nueva Reserva </a>
    @if ($errors->any())
        <div class="alert alert-danger">
            <p class ="text-red-600">{{ session('success') }}</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <p class ="text-green-600">{{ session('success') }}</p>
    @endif
</div>
