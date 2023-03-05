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
                'descripcion' => 'BA101',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA102',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA103',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA104',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA105',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA201',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA202',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA203',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA204',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA205',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA301',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA302',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA303',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA304',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA305',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'BA308',
                'local_id' => '1'
            ],
            [
                'descripcion' => 'Oficina Departamento',
                'local_id' => '1'
            ]
        ]);
    }
}
