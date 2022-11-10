<?php

namespace Database\Seeders;

use App\Models\Ciclo;
use Illuminate\Database\Seeder;

class CicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ciclo::insert([
            [
                'descripcion' => 'I'
            ],
            [
                'descripcion' => 'II'
            ],
            [
                'descripcion' => 'III'
            ],
            [
                'descripcion' => 'IV'
            ],
            [
                'descripcion' => 'V'
            ],
            [
                'descripcion' => 'VI'
            ],
            [
                'descripcion' => 'VII'
            ],
            [
                'descripcion' => 'VIII'
            ],
            [
                'descripcion' => 'IX'
            ],
            [
                'descripcion' => 'X'
            ]
        ]);
    }
}
