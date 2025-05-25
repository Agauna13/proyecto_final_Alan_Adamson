<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $reservaId = null, int $mesaId = null)
    {
        $productos = Producto::with('extras')->get();

        // Si hay mesa o reserva, mostramos la cartaPedidos.
        if ($reservaId || $mesaId) {
            return view('frontend.carta.cartaPedidos', compact('productos'));
        }

        // ⚠️ Esto puede crear redirección infinita si home vuelve a redirigir a redirectToCartaWithMesa.
        // ¡Mejor muestra la carta general sin mesa directamente!
        return view('frontend.carta.carta', compact('productos'));
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
    public function store(StoreProductoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
