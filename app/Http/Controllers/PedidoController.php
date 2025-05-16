<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Mesa;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
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
    public function create(Request $request)
    {
        $cantidades = collect($request->input('cantidad'))->filter(fn($q) => $q > 0);

        $productoUnidades = collect();



        foreach ($cantidades as $productoId => $cantidad) {
            $producto = Producto::with('extras')->find($productoId);
            for ($i = 0; $i < $cantidad; $i++) {
                $productoUnidades->push($producto->replicate()); // cada unidad individual
            }
        }

        //dd($productoUnidades);

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $reservaId = session('reserva_id');
            $mesaId = session('mesa_id');

            $pedido = Pedido::create([
                'reserva_id' => $reservaId,
                'mesa_id' => $mesaId,
            ]);

            $productos = $request->input('productos', []);

            foreach ($productos as $productoData) {
                if (
                    empty($productoData['producto_id']) ||
                    empty($productoData['cantidad']) ||
                    $productoData['cantidad'] <= 0
                ) {
                    continue;
                }

                $productoId = $productoData['producto_id'];
                $precioUnitario = $productoData['precio_unitario'];
                $cantidad = (int) $productoData['cantidad'];

                for ($i = 0; $i < $cantidad; $i++) {
                    // Registrar cada unidad por separado para gestionar extras únicos por unidad
                    $pedido->productos()->attach($productoId, [
                        'cantidad' => 1,
                        'precio_unitario' => $precioUnitario,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $pivotId = DB::table('pedido_productos')
                        ->where('pedido_id', $pedido->id)
                        ->where('producto_id', $productoId)
                        ->latest('id')
                        ->value('id');

                    if (isset($productoData['extras_por_unidad'][$i])) {
                        foreach ($productoData['extras_por_unidad'][$i] as $extraId => $extraCantidad) {
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

            DB::commit();

            // Cargar relaciones
            $pedido->load('productos');

            return view('frontend.pagos.confirmacion', compact('pedido'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar el pedido: ' . $e->getMessage());
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
     * Returns the data from a the menu form into the confirmation view
     */
    public function pedidoConfirmation(Request $request)
    {
        return view('pedidos.confirmacion', ['productos' => $request->all()]);
    }
}
