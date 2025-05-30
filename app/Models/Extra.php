<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'precio'];

    /**
     * Relación entre Extra y Producto.
     *
     * Nota: Aquí parece que quieres una relación many-to-many,
     * pero usas hasMany con la tabla pivote 'productos_extras',
     * lo habitual sería belongsToMany para una relación many-to-many.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'productos_extras');
    }

    /**
     * Relación many-to-many entre Extra y PedidoProducto.
     * Esta relación incluye la columna 'cantidad' en la tabla pivote.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pedidoProductos()
    {
        return $this->belongsToMany(PedidoProducto::class, 'pedido_producto_extras')
            ->withPivot('cantidad');
    }
}
