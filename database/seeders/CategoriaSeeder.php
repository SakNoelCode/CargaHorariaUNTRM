<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::insert([
            ['descripcion'=>'principal'],
            ['descripcion'=>'asociado'],
            ['descripcion'=>'auxiliar'],
            ['descripcion'=>'J.P.']
        ]);
    }
}
