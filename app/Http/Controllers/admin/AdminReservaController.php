<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /**
         * @var \Illuminate\Database\Eloquent\Collection<int, Reserva> $reservas
         * Obtiene todas las reservas con sus pedidos y cliente ordenadas por fecha y hora ascendente
         */
        $reservas = Reserva::with(['pedidos', 'cliente'])
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get()
            ->map(function ($reserva) {
                Carbon::setLocale('es');
                $reserva->fecha_formateada = Carbon::parse($reserva->fecha)->translatedFormat('l d-m-Y');
                $reserva->hora_formateada = Carbon::parse($reserva->hora)->format('H:i');
                return $reserva;
            });

        return view('backend.reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.reservas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            /** @var string $fecha */
            $fecha = $request->fecha;

            /** @var Carbon $hora */
            $hora = Carbon::createFromFormat('H:i', $request->hora);

            /** @var Carbon $inicio - 30 minutos antes */
            $inicio = $hora->copy()->subMinutes(30);

            /** @var Carbon $fin - 30 minutos después */
            $fin = $hora->copy()->addMinutes(30);

            /** @var array<string,int> $capacidad - Capacidad máxima por zona */
            $capacidad = [
                'sala' => 60,
                'terraza' => 30,
            ];

            /**
             * @var int $reservasExistentes
             * Suma de pax reservados en el mismo rango horario y zona
             */
            $reservasExistentes = Reserva::where('fecha', $fecha)
                ->where('sala_terraza', $request->sala_terraza)
                ->whereBetween('hora', [$inicio->format('H:i'), $fin->format('H:i')])
                ->sum('pax');

            /** @var int $capacidadDisponible */
            $capacidadDisponible = $capacidad[$request->sala_terraza] - $reservasExistentes;

            if ($request->pax > $capacidadDisponible) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No hay suficiente espacio disponible en ' . $request->sala_terraza . ' para esa hora.');
            }

            /**
             * @var Cliente $cliente
             * Se crea un nuevo cliente con los datos del formulario
             */
            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'email' => $request->email ?? "Email no proporcionado"
            ]);

            /**
             * Se crea la reserva asociada al cliente creado
             */
            Reserva::create([
                'pax' => $request->pax,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'sala_terraza' => $request->sala_terraza,
                'cliente_id' => $cliente->id
            ]);

            return redirect()->back()->with('success', "Reserva Creada Correctamente");
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Reserva $reserva
     * @return \Illuminate\View\View
     */
    public function show(Reserva $reserva)
    {
        return view('backend.reservas.show', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reserva $reserva
     * @return \Illuminate\View\View
     */
    public function edit(Reserva $reserva)
    {
        return view('backend.reservas.edit', compact('reserva'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        /** @var Reserva $reserva */
        $reserva = Reserva::findOrFail($id);

        $reserva->update([
            'nombre' => $request->nombre,
            'pax' => $request->pax,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'sala_terraza' => $request->sala_terraza
        ]);

        return redirect()->back()->with('success', 'Noticia Actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            Reserva::destroy($id);
            return redirect()->route('admin.reservas.index')->with('success', 'Reseva eliminada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Mostrar reservas para hoy.
     *
     * @return \Illuminate\View\View
     */
    public function mostrarReservasHoy()
    {
        /**
         * @var \Illuminate\Database\Eloquent\Collection<int, Reserva> $reservas
         * Obtiene reservas para la fecha de hoy
         */
        $reservas = Reserva::with(['pedidos', 'cliente'])
            ->where('fecha', Carbon::today())
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get()
            ->map(function ($reserva) {
                Carbon::setLocale('es');
                $reserva->fecha_formateada = Carbon::parse($reserva->fecha)->translatedFormat('l d-m-Y');
                $reserva->hora_formateada = Carbon::parse($reserva->hora)->format('H:i');
                return $reserva;
            });

        return view('backend.reservas.index', compact('reservas'));
    }

    /**
     * Mostrar reservas para la semana desde hoy.
     *
     * @return \Illuminate\View\View
     */
    public function mostrarReservasSemana()
    {
        /** @var Carbon $hoy */
        $hoy = Carbon::today();

        /** @var Carbon $fechaLimite */
        $fechaLimite = $hoy->copy()->addWeek();

        /**
         * @var \Illuminate\Database\Eloquent\Collection<int, Reserva> $reservas
         * Obtiene reservas entre hoy y fecha límite
         */
        $reservas = Reserva::with(['pedidos', 'cliente'])
            ->whereDate('fecha', '>=', $hoy)
            ->whereDate('fecha', '<=', $fechaLimite)
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get()
            ->map(function ($reserva) {
                Carbon::setLocale('es');
                $reserva->fecha_formateada = Carbon::parse($reserva->fecha)->translatedFormat('l d-m-Y');
                $reserva->hora_formateada = Carbon::parse($reserva->hora)->format('H:i');
                return $reserva;
            });

        return view('backend.reservas.index', compact('reservas'));
    }
}
