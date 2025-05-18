<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['mesa_id', 'reserva_id'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedido_productos')
                    ->withPivot('precio_unitario')
                    ->withTimestamps();
    }

    public function pedidoProductos()
    {
        return $this->hasMany(PedidoProducto::class);
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function factura()
    {
        return $this->hasOne(Factura::class);
    }
}
