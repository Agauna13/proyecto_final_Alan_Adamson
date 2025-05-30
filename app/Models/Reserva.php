<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'pax',           // Número de personas de la reserva
        'hora',          // Hora de la reserva
        'fecha',         // Fecha de la reserva
        'cliente_id',    // Id del cliente que hizo la reserva
        'sala_terraza',  // Ubicación (sala o terraza)
        'comentarios'    // Comentarios adicionales sobre la reserva
    ];

    /**
     * Relación con el modelo Cliente.
     *
     * Una reserva pertenece a un cliente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación con el modelo Pedido.
     *
     * Una reserva tiene un pedido asociado (relación uno a uno).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pedidos()
    {
        return $this->hasOne(Pedido::class);
    }
}
