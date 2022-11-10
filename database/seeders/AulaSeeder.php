<?php

namespace Database\Seeders;

use App\Models\Aula;
use Illuminate\Database\Seeder;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Aula::insert([
            [
                'descripcion' => 'BA105',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA203',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA308',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'Oficina Departamento',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA204',
                'local_id' => '1'
            ]
        ]);
    }
}
