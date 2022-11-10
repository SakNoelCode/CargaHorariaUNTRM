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
        Docente::insert([
            [
                'escuela_id' => '1',
                'condicion_id' => '1',
                'categoria_id' => '1',
                'modalidad_id' => '1',
                'user_id' => '3'
            ]
        ]);
    }
}
