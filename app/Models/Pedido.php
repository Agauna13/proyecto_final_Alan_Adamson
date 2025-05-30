<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['mesa_id', 'reserva_id'];

    /**
     * Relación muchos a muchos con productos a través de la tabla 'pedido_productos'.
     * Incluye el precio unitario en la tabla pivote y las marcas de tiempo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedido_productos')
                    ->withPivot('precio_unitario')
                    ->withTimestamps();
    }

    /**
     * Relación uno a muchos con PedidoProducto, representa los detalles específicos
     * de los productos en el pedido (incluyendo extras).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidoProductos()
    {
        return $this->hasMany(PedidoProducto::class);
    }

    /**
     * Relación inversa uno a muchos con Mesa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    /**
     * Relación inversa uno a muchos con Reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }
}
