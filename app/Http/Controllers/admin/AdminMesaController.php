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
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, Mesa> $mesas_sala */
        $mesas_sala = Mesa::where('sala_terraza', 'sala')
            ->with('pedidos')
            ->get();

        /** @var \Illuminate\Database\Eloquent\Collection<int, Mesa> $mesas_terraza */
        $mesas_terraza = Mesa::where('sala_terraza', 'terraza')
            ->with('pedidos')
            ->get();

        /** @var \Illuminate\View\View $vista */
        return view('backend.mesas.index', compact('mesas_sala', 'mesas_terraza'));
    }
    /**
     * Display the specified resource.
     *
     * @param Mesa $mesa
     * @return \Illuminate\View\View
     */
    public function show(Mesa $mesa)
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, Pedido> $pendientes */
        $pendientes = $mesa->pedidos()
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->with([
                'pedidoProductos.producto',
                'pedidoProductos.extras',
                'reserva.cliente'
            ])
            ->get();

        /** @var \Illuminate\Database\Eloquent\Collection<int, Pedido> $historico */
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

        /** @var \Illuminate\View\View $vista */
        return view('backend.mesas.show', compact('mesa', 'pendientes', 'historico'));
    }

    /**
     * Liberar mesa borrando pedidos y marcándola libre.
     *
     * @param Mesa $mesa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function liberarMesa(Mesa $mesa)
    {
        $mesa->pedidos()->delete();
        $mesa->estado = 'libre';
        $mesa->save();

        return redirect()->back()->with('success', 'Mesa liberada correctamente.');
    }

    /**
     * Marcar mesa como ocupada.
     *
     * @param Mesa $mesa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ocuparMesa(Mesa $mesa)
    {
        $mesa->estado = 'ocupada';
        $mesa->save();

        return redirect()->back()->with('success', 'Mesa marcada como ocupada.');
    }

    /**
     * Mostrar mesas ocupadas tanto en sala como terraza.
     *
     * @return \Illuminate\View\View
     */
    public function mesasOcupadas()
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, Mesa> $mesas_sala */
        $mesas_sala = Mesa::where('estado', 'ocupada')
            ->where('sala_terraza', 'sala')
            ->with('pedidos')
            ->get();

        /** @var \Illuminate\Database\Eloquent\Collection<int, Mesa> $mesas_terraza */
        $mesas_terraza = Mesa::where('estado', 'ocupada')
            ->where('sala_terraza', 'terraza')
            ->with('pedidos')
            ->get();

        /** @var \Illuminate\View\View $vista */
        return view('backend.mesas.index', compact('mesas_sala', 'mesas_terraza'));
    }

    /**
     * Mostrar mesas ocupadas filtradas por sala o terraza.
     *
     * @param string $sala_terraza
     * @return \Illuminate\View\View
     */
    public function salaTerraza(string $sala_terraza)
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, Mesa> $mesas */
        $mesas = Mesa::where('sala_terraza', $sala_terraza)
            ->where('estado', 'ocupada')
            ->with('pedidos')
            ->get();

        if ($sala_terraza === 'sala') {
            /** @var \Illuminate\Support\Collection<int, Mesa> $mesas_sala */
            $mesas_sala = $mesas;
            /** @var \Illuminate\Support\Collection<int, Mesa> $mesas_terraza */
            $mesas_terraza = collect();
        } else {
            /** @var \Illuminate\Support\Collection<int, Mesa> $mesas_terraza */
            $mesas_terraza = $mesas;
            /** @var \Illuminate\Support\Collection<int, Mesa> $mesas_sala */
            $mesas_sala = collect();
        }

        /** @var \Illuminate\View\View $vista */
        return view('backend.mesas.index', compact('mesas_sala', 'mesas_terraza'));
    }
}
