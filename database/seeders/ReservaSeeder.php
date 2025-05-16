<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Reserva;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/reservas.json'));

        $productos = json_decode($json, true);

        foreach ($productos as $producto) {
            Reserva::create($producto);
        }
    }
}
