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
     * @param Request $request
     */
    public function store(Request $request)
    {
        /**
         * Creamos 2 arrays para almacenar los entrantes que el cliente pueda
         * pedir adicionalmente y luego lo juntamos todo en un array único
         * para manejar mejor los datos.
         */
        /** @var array $productosRequest */
        $productosRequest = $request->input('productos', []);
        /** @var array $entrantesRequest */
        $entrantesRequest = $request->input('extras_entrantes', []);

        foreach ($entrantesRequest as $entrante => $cantidad) {
            if ($cantidad != 0) {
                for ($i = 0; $i < $cantidad; $i++) {
                    /** @var Producto|null $producto */
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
            //Si la sesión tiene guardados datos destinados a una reserva la creamos
            /** @var Reserva|null $reserva */
            if (session('reserva_temporal')) {
                $reserva = Reserva::create(session('reserva_temporal'));
                $reservaId = $reserva->id;
            }

            /**
             * Si el pedido viene de una mesa, nos quedamos el id que almacena
             * el controlador de mesas en sesión y tras comprobar que no esté
             * ocupada la marcamos como ocupada y seguimos
             */
            /** @var int|null $mesaId */
            $mesaId = session('mesa_id');

            if ($mesaId) {
                /** @var bool $mesaOcupada */
                $mesaOcupada = Mesa::where('estado', 'ocupada')->where('id', $mesaId)->exists();

                if ($mesaOcupada) {
                    return redirect()->route('home')->with('error', "La mesa ya tiene un pedido pendiente");
                }

                /** @var Mesa|null $mesa */
                $mesa = Mesa::find($mesaId);
                $mesa->estado = 'ocupada';
                $mesa->save();
            }

            /**
             * Si el pedido no tiene un id de mesa o reserva, nos rebota a la
             * página de inicio para evitar pedidos duplicados si un cliente
             * vuelve atrás tras la confirmación.
             */
            if (!$mesaId && !isset($reservaId)) {
                return redirect()->route('home');
            }

            /** @var Pedido $pedido */
            $pedido = Pedido::create([
                'reserva_id' => $reservaId ?? null,
                'mesa_id' => $mesaId,
            ]);

            /**
             * Insertamos los datos del pedido con su mesa o reserva (modularizado
             * para mayor legibilidad)
             */
            $this->insertData($productosRequest, $pedido);

            DB::commit();

            session()->forget(['reserva_temporal', 'pedido']);
            return redirect()->route('pedidos.confirmacion', ['pedido' => $pedido->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->forget(['reserva_temporal', 'pedido']);
            return back()->with('error', 'Error al guardar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * @param array $productosRequest
     * @param Pedido $pedido
     */
    protected function insertData($productosRequest, $pedido)
    {
        /**
         * Del array de productos con entrantes extra que hemos formado,
         * creamos el pedido en bbdd, primero en la tabla de pedidos y luego
         * en las tablas intermedias que guardan las relaciones
         */
        foreach ($productosRequest as $productoData) {
            $pedido->productos()->attach([
                $productoData['producto_id'] => [
                    'precio_unitario' => $productoData['precio_unitario'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);

            /** @var int|null $pivotId */
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
     * Método para hacer una redirección a la página de confirmación cuando
     * el cliente confirma el pedido con sus extras en el segundo paso
     * (después de guardar en bbdd).
     */
    /**
     * @param Pedido $pedido
     */
    public function confirmacion(Pedido $pedido)
    {
        $pedido->load('pedidoProductos.producto', 'pedidoProductos.extras', 'reserva.cliente');

        /** @var float $totalProductos */
        $totalProductos = $pedido->pedidoProductos->sum('precio_unitario');

        /** @var float $totalExtras */
        $totalExtras = $pedido->pedidoProductos->flatMap(function ($unidad) {
            return $unidad->extras->map(function ($extra) {
                return $extra->precio * $extra->pivot->cantidad;
            });
        })->sum();

        /** @var float $precioTotal */
        $precioTotal = $totalProductos + $totalExtras;

        $response = response()->view('frontend.pagos.confirmacion', compact('pedido', 'precioTotal'));
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');

        return $response;
    }


    /**
     * Método al que llegamos desde la primera carta de pedidos que mostramos al
     * cliente. Busca en la Request los productos que el cliente haya
     * seleccionado marcando una cantidad Mayor a 0 de ese producto y sumando a
     * la vez al precio total, el precio de cada producto multiplicado por su
     * cantidad.
     */
    /**
     * @param Request $request
     */
    public function redirectToPedido(Request $request)
    {
        /** @var \Illuminate\Support\Collection $cantidades */
        $cantidades = collect($request->input('cantidad'))->filter(fn($cantidad) => $cantidad > 0);

        /** @var \Illuminate\Support\Collection $productoUnidades */
        $productoUnidades = collect();
        /** @var float $precioTotal */
        $precioTotal = 0;

        foreach ($cantidades as $productoId => $cantidad) {
            /** @var Producto|null $producto */
            $producto = Producto::with('extras')->find($productoId);
            $productoUnidades->push($producto);
            $precioTotal += $producto->precio;

            if ($cantidad > 1) {
                for ($i = 0; $i < $cantidad - 1; $i++) {
                    $precioTotal += $producto->precio;
                    /** @var Producto $replica */
                    $replica = $producto->replicate();
                    $replica->id = $productoId;
                    $productoUnidades->push($replica);
                }
            }
        }

        session(['precio_total' => $precioTotal]);

        /** @var array|null $reservaData */
        $reservaData = session('reserva_temporal');
        /** @var Mesa|null $mesa */
        $mesa = session()->has('mesa_id') ? Mesa::find(session('mesa_id')) : null;
        /** @var \Illuminate\Database\Eloquent\Collection<int, Producto> $entrantes */
        $entrantes = Producto::where('categoria', 'Entrantes')->get();

        return view('frontend.pedidos.confirmacion', [
            'productosUnicos' => $productoUnidades,
            'reservaData' => $reservaData,
            'mesa' => $mesa,
            'entrantes' => $entrantes
        ]);
    }
}
