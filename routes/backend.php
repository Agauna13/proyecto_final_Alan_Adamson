<?php

use App\Http\Controllers\admin\AdminClienteController;
use App\Http\Controllers\admin\AdminFacturaController;
use App\Http\Controllers\admin\AdminMesaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminProductoController;
use App\Http\Controllers\admin\AdminPedidoController;
use App\Http\Controllers\admin\AdminReservaController;

Route::get('/dashboard', function(){
    return view('backend.dashboard');
})->name('dashboard');

Route::post('/mesas/{mesa}/liberar', [AdminMesaController::class, 'liberarMesa'])->name('mesas.liberar');
Route::post('/mesas/{mesa}/ocupar', [AdminMesaController::class, 'ocuparMesa'])->name('mesas.ocupar');

Route::post('/admin/pedidos/{pedido}/estado/{estado}', [AdminPedidoController::class, 'cambiarEstadoPedido'])->name('pedidos.estado');

Route::get('/mesasOcupadas', [AdminMesaController::class, 'mesasOcupadas'])->name('mesasOcupadas');
Route::get('/salaTerraza/{sala_terraza}', [AdminMesaController::class, 'salaTerraza'])->name('salaTerraza');
Route::resource('productos', AdminProductoController::class);
Route::resource('pedidos', AdminPedidoController::class);
Route::resource('reservas', AdminReservaController::class);
Route::resource('clientes', AdminClienteController::class);
Route::resource('mesas', AdminMesaController::class);
Route::resource('facturas', AdminFacturaController::class);
