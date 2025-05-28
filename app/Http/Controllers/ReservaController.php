<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReservaRequest;
use App\Http\Requests\UpdateReservaRequest;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Renvío al formulario de  creación de reservas para clientes
     */
    public function create()
    {
        return view('frontend.reservas.create');
    }

    /**
     * Store a newly created resource in storage.
     * @var Request $request
     */
    public function store(Request $request)
    {
        /** @var \Illuminate\Http\RedirectResponse|\Illuminate\View\View $disponibilidad */
        $disponibilidad = $this->comprobarDisponibilidad($request);

        if ($disponibilidad instanceof \Illuminate\Http\RedirectResponse) {
            return $disponibilidad;
        }

        if ($request->action === 'pedido') {
            /** @var Cliente $cliente */
            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'email' => $request->email ?? "Email no proporcionado"
            ]);

            /** @var array $reservaDatos */
            $reservaDatos = $request->all();
            $reservaDatos['cliente_id'] = $cliente->id;
            session(['reserva_temporal' => $reservaDatos]);

            /** @var \Illuminate\Database\Eloquent\Collection<int, Producto> $productos */
            $productos = Producto::with('extras')->get();

            return view('frontend.carta.cartaPedidos', compact('productos'));
        }

        try {
            /** @var Cliente $cliente */
            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'email' => $request->email ?? "Email no proporcionado"
            ]);

            /** @var Reserva $reserva */
            $reserva = Reserva::create([
                'pax' => $request->pax,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'sala_terraza' => $request->sala_terraza,
                'comentarios' => $request->comentarios,
                'cliente_id' => $cliente->id
            ]);

            return view('frontend.reservas.confirmacion', compact('cliente', 'reserva'));
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al crear la reserva.');
        }
    }

    /**
     * Comprueba la disponibilidad y la fecha/hora mínima.
     * @var Request $request
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function comprobarDisponibilidad($request)
    {
        /** @var string $fecha */
        $fecha = $request->fecha;

        /** @var Carbon $hora */
        $hora = Carbon::createFromFormat('H:i', $request->hora);

        // Combinar fecha y hora para compararla con la hora actual + 1h
        /** @var Carbon $fechaHoraReserva */
        $fechaHoraReserva = Carbon::createFromFormat('Y-m-d H:i', "{$fecha} {$hora->format('H:i')}");
        /** @var Carbon $horaMinima */
        $horaMinima = Carbon::now()->addHour();

        if ($fechaHoraReserva->lessThan($horaMinima)) {
            return redirect()->back()
                ->withInput()
                ->with('error', "La reserva debe realizarse al menos con 1 hora de antelación. $fechaHoraReserva");
        }

        /* Comprobamos que no haya 2 reservas a la misma hora con los mismos
        datos de cliente para evitar reservas duplicadas */
        /** @var Reserva|null $reservaExistente */
        $reservaExistente = Reserva::where('fecha', $fecha)
            ->where('hora', $request->hora)
            ->whereHas('cliente', function ($query) use ($request) {
                $query->where('nombre', $request->nombre)
                    ->where('telefono', $request->telefono)
                    ->where('email', $request->email);
            })->first();

        if ($reservaExistente) {
            // Redirigir a la home si la reserva está duplicada
            return redirect()->route('home');
        }

        // Verificar aforo disponible
        /** @var Carbon $inicio */
        $inicio = $hora->copy()->subMinutes(30);
        /** @var Carbon $fin */
        $fin = $hora->copy()->addMinutes(30);

        /** @var array<string, int> $capacidad */
        $capacidad = [
            'sala' => 60,
            'terraza' => 30,
        ];

        /** @var int $reservasExistentes */
        $reservasExistentes = Reserva::where('fecha', $fecha)
            ->where('sala_terraza', $request->sala_terraza)
            ->whereBetween('hora', [$inicio->format('H:i'), $fin->format('H:i')])
            ->sum('pax');

        /** @var int $capacidadDisponible */
        $capacidadDisponible = $capacidad[$request->sala_terraza] - $reservasExistentes;

        if ($request->pax > $capacidadDisponible) {
            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'No hay suficiente espacio disponible en '
                        . $request->sala_terraza
                        . ' para esa hora.'
                );
        }
    }
}
