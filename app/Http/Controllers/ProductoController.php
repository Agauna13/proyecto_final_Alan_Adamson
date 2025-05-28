<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;

class ProductoController extends Controller
{
    /**
     * Redirigimos a la carta normal o la de pedidos dependiendo de la petición
     *  del cliente
     * @var int|null $reservaId
     * @var int|null $mesaId
     */
    public function index(int $reservaId = null, int $mesaId = null)
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, Producto> $productos */
        $productos = Producto::with('extras')->get();

        // Si hay mesa o reserva, mostramos la cartaPedidos.
        if ($reservaId || $mesaId) {
            return view('frontend.carta.cartaPedidos', compact('productos'));
        }

        return view('frontend.carta.carta', compact('productos'));
    }
}
