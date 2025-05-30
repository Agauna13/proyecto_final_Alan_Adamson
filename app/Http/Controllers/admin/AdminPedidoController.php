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
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /**
         * @var \Illuminate\Database\Eloquent\Collection<int, Pedido> $pedidos
         * Obtiene todos los pedidos con sus relaciones necesarias ordenados por fecha descendente
         */
        $pedidos = Pedido::with([
            'pedidoProductos.producto',
            'pedidoProductos.extras',
            'mesa',
            'reserva.cliente'
        ])->latest()->get();

        /**
         * @var \Illuminate\View\View $vista
         * Retorna la vista con los pedidos
         */
        return view('backend.pedidos.index', compact('pedidos'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.pedidos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Pedido $pedido
     * @return \Illuminate\View\View
     */
    public function show(Pedido $pedido)
    {
        /**
         * Carga las relaciones necesarias del pedido
         * @var Pedido $pedido
         */
        $pedido->load(
            'pedidoProductos.producto',
            'pedidoProductos.extras',
            'reserva.cliente',
            'mesa'
        );

        /**
         * @var float $totalProductos
         * Suma el precio unitario de todos los productos del pedido
         */
        $totalProductos = $pedido->pedidoProductos->sum('precio_unitario');

        /**
         * @var float $totalExtras
         * Calcula la suma del precio de todos los extras multiplicado por su cantidad
         */
        $totalExtras = $pedido->pedidoProductos->flatMap(function ($unidad) {
            return $unidad->extras->map(function ($extra) {
                return $extra->precio * $extra->pivot->cantidad;
            });
        })->sum();

        /**
         * @var float $precioTotal
         * Precio total del pedido sumando productos y extras
         */
        $precioTotal = $totalProductos + $totalExtras;

        /**
         * @var \Illuminate\View\View $vista
         * Retorna la vista con el pedido y el precio total
         */
        return view('backend.pedidos.show', compact('pedido', 'precioTotal'));
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
            Pedido::findOrFail($id)->delete();

            return redirect()->route('admin.pedidos.index')->with('success', 'Pedido eliminado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Cambia el estado de un pedido dado.
     *
     * @param Pedido $pedido
     * @param string $estado
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cambiarEstadoPedido(Pedido $pedido, string $estado)
    {
        /** @var int $pedidoId */
        $pedidoId = $pedido->id;

        $pedido->estado = $estado;
        $pedido->save();

        return redirect()->back()->with('success', "Pedido nº $pedidoId Cancelado Correctamente");
    }

    /**
     * Muestra los pedidos realizados hoy.
     *
     * @return \Illuminate\View\View
     */
    public function mostrarPedidosHoy()
    {
        /** @var Carbon $hoy */
        $hoy = Carbon::today();

        /**
         * @var \Illuminate\Database\Eloquent\Collection<int, Pedido> $pedidos
         * Obtiene pedidos con reserva en la fecha de hoy o sin reserva
         */
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

    /**
     * Muestra los pedidos realizados durante la semana desde hoy.
     *
     * @return \Illuminate\View\View
     */
    public function mostrarPedidosSemana()
    {
        /** @var Carbon $hoy */
        $hoy = Carbon::today();
        /** @var Carbon $fechaLimite */
        $fechaLimite = $hoy->copy()->addWeek();

        /**
         * @var \Illuminate\Database\Eloquent\Collection<int, Pedido> $pedidos
         * Obtiene pedidos con reserva entre hoy y la fecha límite o sin reserva
         */
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
