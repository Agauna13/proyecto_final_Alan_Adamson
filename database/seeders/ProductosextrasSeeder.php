<?php

namespace Database\Seeders;

use App\Models\Productosextras;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductosextrasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/productosExtras.json'));

        $productos = json_decode($json, true);

        foreach ($productos as $producto) {
            Productosextras::create($producto);
        }
    }
}
