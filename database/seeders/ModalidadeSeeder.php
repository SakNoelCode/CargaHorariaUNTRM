<?php

namespace Database\Seeders;

use App\Models\Modalidade;
use Illuminate\Database\Seeder;

class ModalidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modalidade::insert([
            [
                'descripcion' => 'tiempo completo',
                'horas' => 40
            ],
            [
                'descripcion' => 'tiempo parcial',
                'horas' => 20
            ],
            [
                'descripcion' => 'DE.',
                'horas' => 30
            ]
        ]);
    }
}
