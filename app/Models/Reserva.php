<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = ['pax', 'hora', 'fecha', 'cliente_id', 'sala_terraza', 'comentarios'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pedidos()
    {
        return $this->hasOne(Pedido::class);
    }
}
