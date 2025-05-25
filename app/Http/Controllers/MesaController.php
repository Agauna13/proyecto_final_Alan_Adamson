<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Producto;
use App\Http\Requests\StoreMesaRequest;
use App\Http\Requests\UpdateMesaRequest;

class MesaController extends Controller
{
    public function redirectToCartaWithMesa($mesa_id)
    {
        $mesa = Mesa::where('mesa_hash', $mesa_id)->first();

        if ($mesa) {
            $tienePedidosPendientes = $mesa->pedidosPendientes()->exists();
            $mesaOcupada = $mesa->estado === 'ocupada';

            //Si la mesa está libre y sin pedidos, mostramos la carta
            if (!$tienePedidosPendientes && !$mesaOcupada) {
                $productos = Producto::with('extras')->get();
                session(['mesa_id' => $mesa->id]);
                return view('frontend.carta.cartaPedidos', [
                    'mesaId' => $mesa->id,
                    'productos' => $productos
                ]);
            }
        }

        //Para cualquier otro caso: mesa no existe, está ocupada o tiene pedidos pendientes
        return redirect()->route('home')->with('error', 'Mesa Ocupada, por favor, consulte al camarero. Puedes echar un vistazo a la carta hasta que llegue.');
    }
}
