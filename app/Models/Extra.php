<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'precio'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'productos_extras');
    }

    public function pedidoProductos()
    {
        return $this->belongsToMany(PedidoProducto::class, 'pedido_producto_extras')
            ->withPivot('cantidad');
    }
}
