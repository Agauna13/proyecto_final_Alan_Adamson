<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use Carbon\Carbon;

class AdminPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with([
            'pedidoProductos.producto',
            'pedidoProductos.extras',
            'mesa',
            'reserva.cliente'
        ])->latest()->get();

        return view('backend.pedidos.index', compact('pedidos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pedidos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        $pedido->load(
            'pedidoProductos.producto',
            'pedidoProductos.extras',
            'reserva.cliente',
            'mesa'
        );

        $totalProductos = $pedido->pedidoProductos->sum('precio_unitario');

        $totalExtras = $pedido->pedidoProductos->flatMap(function ($unidad) {
            return $unidad->extras->map(function ($extra) {
                return $extra->precio * $extra->pivot->cantidad;
            });
        })->sum();

        $precioTotal = $totalProductos + $totalExtras;

        return view('backend.pedidos.show', compact('pedido', 'precioTotal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            Pedido::findOrFail($id)->delete();

            return redirect()->route('admin.pedidos.index')->with('success', 'Pedido eliminado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cambiarEstadoPedido(Pedido $pedido, string $estado)
    {
        $pedidoId = $pedido->id;
        $pedido->estado = $estado;
        $pedido->save();
        return redirect()->back()->with('success', "Pedido nº $pedidoId Cancelado Correctamente");
    }

    public function mostrarPedidosHoy()
    {
        $hoy = Carbon::today();

        $pedidos = Pedido::with(['productos', 'reserva'])
            ->where(function ($query) use ($hoy) {
                $query->whereHas('reserva', function ($q) use ($hoy) {
                    $q->whereDate('fecha', $hoy);
                })
                    ->orWhereDoesntHave('reserva');
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($pedido) {
                Carbon::setLocale('es');
                $pedido->fecha_formateada = Carbon::parse($pedido->created_at)->translatedFormat('l d-m-Y');
                $pedido->hora_formateada = Carbon::parse($pedido->created_at)->format('H:i');
                return $pedido;
            });

        return view('backend.pedidos.index', compact('pedidos'));
    }



    public function mostrarPedidosSemana()
    {
        $hoy = Carbon::today();
        $fechaLimite = $hoy->copy()->addWeek();

        $pedidos = Pedido::with(['productos', 'reserva'])
            ->where(function ($query) use ($hoy, $fechaLimite) {
                $query->whereHas('reserva', function ($q) use ($hoy, $fechaLimite) {
                    $q->whereDate('fecha', '>=', $hoy)
                        ->whereDate('fecha', '<=', $fechaLimite);
                })
                    ->orWhereDoesntHave('reserva');
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($pedido) {
                Carbon::setLocale('es');
                $pedido->fecha_formateada = Carbon::parse($pedido->created_at)->translatedFormat('l d-m-Y');
                $pedido->hora_formateada = Carbon::parse($pedido->created_at)->format('H:i');
                return $pedido;
            });

        return view('backend.pedidos.index', compact('pedidos'));
    }
}
