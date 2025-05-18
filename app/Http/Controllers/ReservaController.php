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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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

            $capacidadDisponible = $capacidad[$request->sala_terraza] - $reservasExistentes;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservaRequest $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        //
    }
}
