<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MesaController;
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
Route::match(['get', 'post'], '/pedidos/revisa-tu-pedido', [PedidoController::class, 'redirectToPedido'])
    ->name('pedidos.redirectToPedido');

Route::get('/pedidos/{pedido}/confirmacion', [PedidoController::class, 'confirmacion'])->name('pedidos.confirmacion');

Route::get('/carta', [ProductoController::class, 'index'])->name('carta');
Route::get('/', fn() =>  view('frontend.home'))->name('home');

Route::get('/mesa/{hash}', [MesaController::class, 'redirectToCartaWithMesa']);

Route::resource('productos', ProductoController::class);
Route::resource('pedidos', PedidoController::class);
Route::resource('reservas', ReservaController::class);



require __DIR__.'/auth.php';
