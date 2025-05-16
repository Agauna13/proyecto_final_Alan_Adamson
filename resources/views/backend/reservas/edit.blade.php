<h3 class="text-red-600 font-bold text-[24px]">Editar Reserva</h3>
    <form action="{{ route('admin.reservas.update', $reserva->id) }}" method="POST" class="flex flex-col gap-4 m-3">
        @csrf
        @method('PUT')
            <div class="flex flex-col m-3">
                <input type="text" name="nombre"
                    value="{{ old('nombre', $reserva->cliente->nombre,  '') }}"
                    placeholder="{{ $reserva->cliente->nombre ?? '' }}" class="w-full border-0" />
                <input type="text" name="pax"
                    value="{{ old('pax', $Reserva->pax ?? '') }}"
                    placeholder="{{ $reserva->pax }}" class="w-full border-0" />

                <input type="date" name="fecha"
                    value="{{ old('fecha', $reserva->fecha ?? '') }}"
                    placeholder="{{ $reserva->fecha }}" class="w-full border-0" />
                </br>
                <input type="time" name="hora"
                    value="{{ old('hora', $reserva->hora ?? '') }}"
                    placeholder="{{ $reserva->hora }}" class="w-full border-0" />
                <select type="text" name="sala_terraza"
                    value="{{ old('sala_terraza', $reserva->sala_terraza ?? '') }}">
                    <option value="sala"> Sala </option>
                    <option value="terraza"> Terraza </option>
                </select>
            </div>
        <button type="submit"
            class="bg-red-600 text-white text-[24px] hover:text-red-600 hover:bg-white rounded-lg w-fit min-w-fit px-4 py-5 mt-[20px]">Guardar
            Cambios</button>
    </form>
