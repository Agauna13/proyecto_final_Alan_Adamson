<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesa;
use App\Models\Pedido;

class AdminMesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mesas_sala = Mesa::where('sala_terraza', 'sala')
            ->with('pedidos')
            ->get();
        $mesas_terraza = Mesa::where('sala_terraza', 'terraza')
            ->with('pedidos')
            ->get();
        return view('backend.mesas.index', compact('mesas_sala', 'mesas_terraza'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Mesa $mesa)
    {
        // Pedidos pendientes
        $pendientes = $mesa->pedidos()
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->with([
                'pedidoProductos.producto',
                'pedidoProductos.extras',
                'reserva.cliente'
            ])
            ->get();

        // Pedidos servidos (incluso soft deleted si quieres mostrar histórico)
        $historico = Pedido::withTrashed()
            ->where('mesa_id', $mesa->id)
            ->whereIn('estado', ['servido', 'cancelado'])
            ->orderBy('created_at', 'desc')
            ->with([
                'pedidoProductos.producto',
                'pedidoProductos.extras',
                'reserva.cliente'
            ])
            ->get();

        return view('backend.mesas.show', compact('mesa', 'pendientes', 'historico'));
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
    public function destroy(string $id)
    {
        //
    }

    public function liberarMesa(Mesa $mesa)
    {

        $mesa->pedidos()->delete();
        $mesa->estado = 'libre';
        $mesa->save();

        return redirect()->back()->with('success', 'Mesa liberada correctamente.');
    }


    public function ocuparMesa(Mesa $mesa)
    {
        $mesa->estado = 'ocupada';
        $mesa->save();

        return redirect()->back()->with('success', 'Mesa marcada como ocupada.');
    }



    public function mesasOcupadas()
    {

        $mesas_sala = Mesa::where('estado', 'ocupada')
            ->where('sala_terraza', 'sala')
            ->with('pedidos')
            ->get();

        $mesas_terraza = Mesa::where('estado', 'ocupada')
            ->where('sala_terraza', 'terraza')
            ->with('pedidos')
            ->get();


        return view('backend.mesas.index', compact('mesas_sala', 'mesas_terraza'));
    }

    public function salaTerraza(string $sala_terraza)
    {
        $mesas = Mesa::where('sala_terraza', $sala_terraza)
            ->where('estado', 'ocupada')
            ->with('pedidos')
            ->get();

        if ($sala_terraza === 'sala') {
            $mesas_sala = $mesas;
            $mesas_terraza = collect();
        } else {
            $mesas_terraza = $mesas;
            $mesas_sala = collect();
        }

        return view('backend.mesas.index', compact('mesas_sala', 'mesas_terraza'));
    }
}
