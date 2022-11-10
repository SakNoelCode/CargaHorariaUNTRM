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
                'descripcion' => 'facultad de ingeniería de sistemas y mecánica eléctrica'
            ],
            [
                'descripcion' => 'facultad de ingeniería civil y ambiental'
            ]
        ]);
    }
}
