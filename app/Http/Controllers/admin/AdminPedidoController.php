<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;

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
            'reserva.cliente'
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
            Pedido::findOrFail($id)->delete(); // en vez de destroy()

            return redirect()->route('admin.pedidos.index')->with('success', 'Pedido eliminado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
