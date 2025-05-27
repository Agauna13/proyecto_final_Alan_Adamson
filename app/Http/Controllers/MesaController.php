<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Producto;
use App\Http\Requests\StoreMesaRequest;
use App\Http\Requests\UpdateMesaRequest;

class MesaController extends Controller
{

    /*único controlador para mesas del front end que nos interesa,
    comprueba que exista la mesa mediante el Hash
    Seguidamente si la mesa tiene pedidos pendientes o está ocupada,
    el cliente es reenviado al inicio
    para evitar conflictos en los pedidos o verificar que todas las mesas
    hayan sido cobradas.*/
    public function redirectToCartaWithMesa($mesa_id)
    {
        $mesa = Mesa::where('mesa_hash', $mesa_id)->first();

        if ($mesa) {
            $tienePedidosPendientes = $mesa->pedidosPendientes()->exists();
            $mesaOcupada = $mesa->estado === 'ocupada';

            if (!$tienePedidosPendientes && !$mesaOcupada) {
                $productos = Producto::with('extras')->get();
                session(['mesa_id' => $mesa->id]);
                return view('frontend.carta.cartaPedidos', [
                    'mesaId' => $mesa->id,
                    'productos' => $productos
                ]);
            }
        }

        return redirect()->route('carta')->with('error', 'Mesa Ocupada, por favor, consulte al camarero. Puedes echar un vistazo a la carta hasta que llegue.');
    }
}
