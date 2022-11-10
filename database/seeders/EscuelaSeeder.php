<?php

namespace Database\Seeders;

use App\Models\Escuela;
use Illuminate\Database\Seeder;

class EscuelaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Escuela::insert([
            [
                'descripcion' => 'Ingeniería de Sistemas',
                'facultad_id' => '1'
            ],
            [
                'descripcion' => 'Mecánica eléctrica',
                'facultad_id' => '1'
            ]
        ]);
    }
}
