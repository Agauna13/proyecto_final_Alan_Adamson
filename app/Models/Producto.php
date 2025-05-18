<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'categoria', 'grupo', 'precio', 'css_id'];

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_producto')
                    ->withPivot('precio_unitario')
                    ->withTimestamps();
    }

    public function extras()
    {
        return $this->belongsToMany(Extra::class, 'productos_extras', 'producto_id', 'extra_id');
    }
}
