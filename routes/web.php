<?php

use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/pedidos/{pedido}/confirmacion', [PedidoController::class, 'confirmacion'])->name('pedidos.confirmacion');
Route::post('/pedidos/redireccion-pedido', [PedidoController::class, 'redirectToPedido'])->name('pedidos.redirectToPedido');


Route::get('/', [ProductoController::class, 'index'])->name('home');

Route::resource('productos', ProductoController::class);
Route::resource('pedidos', PedidoController::class);
Route::resource('reservas', ReservaController::class);
