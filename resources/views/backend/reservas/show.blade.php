<div>
    <p>Cliente: {{ $reserva->cliente->nombre }}</p>
    <p>Pax: {{ $reserva->pax }}</p>

    @if ($reserva->pedidos)
        <p>Pedido ID: {{ $reserva->pedidos->id }}</p>
        <p>Detalle: {{ $reserva->pedidos->detalle }}</p>
    @else
        <p><em>Sin pedido</em></p>
    @endif

    <form action="{{ route('admin.reservas.destroy', $reserva->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type ="submit"> Borrar </button>
    </form>

    <a href="{{ route('admin.reservas.edit', $reserva) }}">
        Editar Reserva
    </a>
</div>
