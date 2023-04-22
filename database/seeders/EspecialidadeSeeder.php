<?php

namespace Database\Seeders;

use App\Models\Especialidade;
use Illuminate\Database\Seeder;

class EspecialidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Especialidade::insert([
            [
                'descripcion' => 'programación'
            ],
            [
                'descripcion' => 'bases de datos'
            ],
            [
                'descripcion' => 'matemáticas'
            ],
            [
                'descripcion' => 'lenguaje'
            ],
            [
                'descripcion' => 'investigación'
            ],
            [
                'descripcion' => 'redes'
            ],
            [
                'descripcion' => 'fisica'
            ],
            [
                'descripcion' => 'economía'
            ],
            [
                'descripcion' => 'general'
            ],
            [
                'descripción' => 'inteligencia artificial'
            ],
            [
                'descripción' => 'estadística'
            ]
        ]);
    }
}
