<?php

namespace Database\Seeders;

use App\Models\JefeDepartamento;
use Illuminate\Database\Seeder;

class JefeDepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JefeDepartamento::insert([
            [
                'user_id' => '2',
                'escuela_id' => '1'
            ]
        ]);
    }
}
