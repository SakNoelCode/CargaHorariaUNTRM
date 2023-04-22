<?php

namespace Database\Seeders;

use App\Models\Docente;
use Illuminate\Database\Seeder;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $docente = Docente::create(
            [
                'escuela_id' => '1',
                'condicion_id' => '1',
                'categoria_id' => '1',
                'modalidad_id' => '1',
                'user_id' => '3'
            ]
        );

        $docente->especialidades()->attach([
            1,
            2
        ]);

        $docente2 = Docente::create(
            [
                'escuela_id' => '1',
                'condicion_id' => '1',
                'categoria_id' => '1',
                'modalidad_id' => '1',
                'user_id' => '4'
            ],
        );

        $docente2->especialidades()->attach([
            5,
            6,
            9
        ]);
    }
}
