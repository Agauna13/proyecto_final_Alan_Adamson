<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantidadMesas = 40;

        for ($i = 1; $i <= $cantidadMesas; $i++) {
            $salaTerraza = $i<= 25 ? 'sala' : 'terraza';
            DB::table('mesas')->insert([
                'mesa_hash' => sha1($i),
                'sala_terraza' => $salaTerraza,
            ]);
        }
    }
}
