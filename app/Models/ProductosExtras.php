<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosExtras extends Model
{
    use HasFactory;

    /**
     * Nombre explícito de la tabla en la base de datos
     *
     * @var string
     */
    protected $table = 'productos_extras';

    /**
     * Campos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['producto_id', 'extra_id'];
}
