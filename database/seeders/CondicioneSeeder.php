<?php

namespace Database\Seeders;

use App\Models\Condicione;
use Illuminate\Database\Seeder;

class CondicioneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condicione::insert([
            ['descripcion' => 'regular'],
            ['descripcion' => 'contratado']
        ]);
    }
}
