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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.reservas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar disponibilidad
        $disponibilidad = $this->comprobarDisponibilidad($request);
        if ($disponibilidad instanceof \Illuminate\Http\RedirectResponse) {
            return $disponibilidad; // Redirigir si hay error
        }

        if ($request->action === 'pedido') {
            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'email' => $request->email ?? "Email no proporcionado"
            ]);

            $reservaDatos = $request->all();
            $reservaDatos['cliente_id'] = $cliente->id;
            session(['reserva_temporal' => $reservaDatos]);

            $productos = Producto::with('extras')->get();

            return view('frontend.carta.cartaPedidos', compact('productos'));
        }

        try {
            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'email' => $request->email ?? "Email no proporcionado"
            ]);

            Reserva::create([
                'pax' => $request->pax,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'sala_terraza' => $request->sala_terraza,
                'cliente_id' => $cliente->id
            ]);

            return redirect()->back()->with('success', "Reserva Creada Correctamente");
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al crear la reserva.');
        }
    }

    /**
     * Comprueba la disponibilidad y la fecha/hora mínima.
     */
    public function comprobarDisponibilidad($request)
    {
        $fecha = $request->fecha;
        $hora = Carbon::createFromFormat('H:i', $request->hora);

        // Combinar fecha y hora para compararla con la hora actual + 1h
        $fechaHoraReserva = Carbon::createFromFormat('Y-m-d H:i', "{$fecha} {$hora->format('H:i')}");
        $horaMinima = Carbon::now()->addHour();

        if ($fechaHoraReserva->lessThan($horaMinima)) {
            return redirect()->back()
                ->withInput()
                ->with('error', "La reserva debe realizarse al menos con 1 hora de antelación. $fechaHoraReserva");
        }

        // Verificar aforo disponible
        $inicio = $hora->copy()->subMinutes(30);
        $fin = $hora->copy()->addMinutes(30);

        $capacidad = [
            'sala' => 60,
            'terraza' => 30,
        ];

        $reservasExistentes = Reserva::where('fecha', $fecha)
            ->where('sala_terraza', $request->sala_terraza)
            ->whereBetween('hora', [$inicio->format('H:i'), $fin->format('H:i')])
            ->sum('pax');

        $capacidadDisponible = $capacidad[$request->sala_terraza] - $reservasExistentes;

        if ($request->pax > $capacidadDisponible) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No hay suficiente espacio disponible en ' . $request->sala_terraza . ' para esa hora.');
        }
    }
}
