<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProducto extends Model
{
    use HasFactory;

    /**
     * Relación muchos a muchos con la clase Extra a través de la tabla pivote 'pedido_producto_extras'.
     * Incluye el campo 'cantidad' en la tabla pivote.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function extras()
    {
        return $this->belongsToMany(Extra::class, 'pedido_producto_extras')
                    ->withPivot('cantidad');
    }

    /**
     * Relación inversa uno a muchos con Pedido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    /**
     * Relación inversa uno a muchos con Producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
