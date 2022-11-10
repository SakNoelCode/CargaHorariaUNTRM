<?php

namespace Database\Seeders;

use App\Models\Seccion;
use Illuminate\Database\Seeder;

class SeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seccion::insert([
            [
                'descripcion' => 'a'
            ],
            [
                'descripcion' => 'b'
            ]
        ]);
    }
}
