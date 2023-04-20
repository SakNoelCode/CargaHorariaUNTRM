<?php

namespace Database\Seeders;

use App\Models\Facultad;
use Illuminate\Database\Seeder;

class FacultadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Facultad::insert([
            [
                'descripcion' => 'Ingeniería de Sistemas y Mecánica Eléctrica'
            ],
            [
                'descripcion' => 'Ingeniería Civil y Ambiental'
            ]
        ]);
    }
}
