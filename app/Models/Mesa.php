<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function pedidosPendientes()
    {
        return $this->hasMany(Pedido::class)->where('estado', 'pendiente');
    }

    public function pedidosServidos()
    {
        return $this->hasMany(Pedido::class)->where('estado', 'servido');
    }
}
