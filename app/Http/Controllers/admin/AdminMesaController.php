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
        $mesas = Mesa::with('pedidos')->get();
        return view('backend.mesas.index', compact('mesas'));
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
    public function show(string $id)
    {
        //
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

    public function mesasOcupadas()
    {

        $mesas = Mesa::whereHas('pedidos', function ($query) {
            $query->where('estado', 'pendiente');
        })
            ->get();

        // Luego para cada mesa cargas pedidos pendientes explícitamente:
        foreach ($mesas as $mesa) {
            $mesa->pedidos_pendientes = Pedido::where('mesa_id', $mesa->id)
                ->where('estado', 'pendiente')
                ->orderBy('created_at')
                ->get();
        }


        return view('backend.mesas.index', compact('mesas'));
    }
}
