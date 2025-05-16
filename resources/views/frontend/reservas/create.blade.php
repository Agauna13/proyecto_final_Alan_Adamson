<form method="POST" action="{{ route('reservas.store') }}">
    @csrf
    <label for="nombre">Nombre Cliente</label>
    <input type="text" name="nombre" value="{{ old('nombre') }}">
    <label for="telefono">Teléfono</label>
    <input type="text" name="telefono" value="{{ old('telefono') }}">
    <label for="email">Email</label>
    <input type="text" name="email" value="{{ old('email') }}">
    <label for="pax">Pax</label>
    <input type="number" name="pax" value="{{ old('pax') }}">

    <label for="fecha">Fecha</label>
    <input type="date" name="fecha" value="{{ old('fecha') }}">

    <label for="hora">Hora</label>
    <input type="time" name="hora" value="{{ old('hora') }}">

    <select type="text" name="sala_terraza">
        <option value="sala"> Sala </option>
        <option value="terraza"> Terraza </option>
    </select>

    <button type="submit" name="action" value="guardar">
        Enviar sin hacer Pedido
    </button>

    <button type="submit" name="action" value="pedido">
        Quiero pedir mi comida ahora
    </button>
</form>
@if (session('error'))
    <div class="alert alert-danger">
        <p class="text-red-600">{{ session('error') }}</p>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        <p class="text-green-600">{{ session('success') }}</p>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
