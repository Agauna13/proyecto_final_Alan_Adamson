<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    /**
     * Obtiene todos los pedidos asociados a la mesa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Obtiene los pedidos pendientes (estado = 'pendiente') de la mesa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidosPendientes()
    {
        return $this->hasMany(Pedido::class)->where('estado', 'pendiente');
    }

    /**
     * Obtiene los pedidos servidos (estado = 'servido') de la mesa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidosServidos()
    {
        return $this->hasMany(Pedido::class)->where('estado', 'servido');
    }
}
