<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosExtras extends Model
{
    use HasFactory;

    protected $table = 'productos_extras';
    protected $fillable = ['producto_id', 'extra_id'];
}
