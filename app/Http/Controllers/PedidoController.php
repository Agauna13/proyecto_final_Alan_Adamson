<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Mesa;
use App\Models\Extra;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PedidoController extends Controller
{
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
        $productosRequest = $request->input('productos', []);
        $entrantesRequest = $request->input('extras_entrantes', []);

        foreach ($entrantesRequest as $entrante => $cantidad) {
            if ($cantidad != 0) {
                for ($i = 0; $i < $cantidad; $i++) {
                    $producto = Producto::find($entrante);
                    $productosRequest[] = [
                        'producto_id' => $producto->id,
                        'precio_unitario' => $producto->precio
                    ];
                }
            }
        }

        DB::beginTransaction();

        try {

            $reserva = Reserva::create(session('reserva_temporal'));

            $reservaId = $reserva->id;
            $mesaId = session('mesa_id');

            $pedido = Pedido::create([
                'reserva_id' => $reservaId,
                'mesa_id' => $mesaId,
            ]);

            $this->insertData($productosRequest, $pedido); //método para modularizar el insertData

            DB::commit();

            session()->forget('reserva_temporal');
            // Cargar relaciones
            return redirect()->route('pedidos.confirmacion', ['pedido' => $pedido->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar el pedido: ' . $e->getMessage());
        }
    }

    protected function insertData($productosRequest, $pedido)
    {
        foreach ($productosRequest as $productoData) {
            // Registrar cada unidad por separado para gestionar extras únicos por unidad
            $pedido->productos()->attach([//sin el attach, laravel une los productos del mismo id en uno solo creando confusión a la hora de mostrar los extras
                $productoData['producto_id'] => [
                    'precio_unitario' => $productoData['precio_unitario'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);


            $pivotId = DB::table('pedido_productos')
                ->where('pedido_id', $pedido->id)
                ->where('producto_id', $productoData['producto_id'])
                ->latest('id')
                ->value('id');

            if (isset($productoData['extras_por_unidad'])) {
                foreach ($productoData['extras_por_unidad'] as $extraId => $extraCantidad) {
                    if ($extraCantidad > 0) {
                        DB::table('pedido_producto_extras')->insert([
                            'pedido_producto_id' => $pivotId,
                            'extra_id' => $extraId,
                            'cantidad' => $extraCantidad,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePedidoRequest $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }

    /**
     * Once the order is confirmed with the extra
     */
    public function confirmacion(Pedido $pedido)
    {
        $pedido->load('pedidoProductos.producto', 'pedidoProductos.extras');

        $totalProductos = $pedido->pedidoProductos->sum('precio_unitario');

        $totalExtras = $pedido->pedidoProductos->flatMap(function ($unidad) {
            return $unidad->extras->map(function ($extra) {
                return $extra->precio * $extra->pivot->cantidad;
            });
        })->sum();

        $precioTotal = $totalProductos + $totalExtras;

        return view('frontend.pagos.confirmacion', compact('pedido', 'precioTotal'));
    }




    public function redirectToPedido(Request $request)
    {
        $cantidades = collect($request->input('cantidad'))->filter(fn($q) => $q > 0);

        $productoUnidades = collect();
        $precioTotal = 0;

        foreach ($cantidades as $productoId => $cantidad) {
            $producto = Producto::with('extras')->find($productoId);
            $productoUnidades->push($producto);
            $precioTotal += $producto->precio;
            if ($cantidad > 1) {
                for ($i = 0; $i < $cantidad - 1; $i++) {
                    $precioTotal += $producto->precio;
                    $replica = $producto->replicate();
                    $replica->id = $productoId;
                    $productoUnidades->push($replica); // cada unidad individual
                }
            }
        }

        session(['precio_total' => $precioTotal]);
        $reservaData = session('reserva_temporal');
        $mesa = session()->has('mesa_id') ? Mesa::find(session('mesa_id')) : null;
        $entrantes = Producto::where('categoria', 'Entrantes')->get();

        return view('frontend.pedidos.confirmacion', [
            'productosUnicos' => $productoUnidades,
            'reservaData' => $reservaData,
            'mesa' => $mesa,
            'entrantes' => $entrantes
        ]);
    }
}
