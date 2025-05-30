<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class AdminClienteController extends Controller
{
    /**
     * Muestra un listado de todos los clientes con sus reservas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cliente> $clientes */
        $clientes = Cliente::with('reservas')->get();

        /** @var \Illuminate\View\View $vista */
        return view('backend.clientes.index', compact('clientes'));
    }
}
