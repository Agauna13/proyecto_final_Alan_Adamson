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
     */
    public function index()
    {
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
     */
    public function create()
    {
        return view('backend.reservas.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $fecha = $request->fecha;
            $hora = Carbon::createFromFormat('H:i', $request->hora);
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
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        return view('backend.reservas.show', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        return view('backend.reservas.edit', compact('reserva'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
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

    public function mostrarReservasHoy()
    {
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

    public function mostrarReservasSemana()
    {
        $hoy = Carbon::today();
        $fechaLimite = $hoy->copy()->addWeek();

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
