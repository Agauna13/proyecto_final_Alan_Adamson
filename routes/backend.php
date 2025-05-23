<?php

use App\Http\Controllers\admin\AdminClienteController;
use App\Http\Controllers\admin\AdminFacturaController;
use App\Http\Controllers\admin\AdminMesaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminProductoController;
use App\Http\Controllers\admin\AdminPedidoController;
use App\Http\Controllers\admin\AdminReservaController;

Route::get('/', function(){
    return view('backend.dashboard');
});
Route::get('/mesasOcupadas', [AdminMesaController::class, 'mesasOcupadas'])->name('mesasOcupadas');
Route::resource('productos', AdminProductoController::class);
Route::resource('pedidos', AdminPedidoController::class);
Route::resource('reservas', AdminReservaController::class);
Route::resource('clientes', AdminClienteController::class);
Route::resource('mesas', AdminMesaController::class);
Route::resource('facturas', AdminFacturaController::class);
