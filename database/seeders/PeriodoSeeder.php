<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Periodo::insert([
            [
                'descripcion' => '2022-I',
                'inicio_periodo' => '2022/04/25',
                'fin_periodo' => '2022/06/24'
            ],
            [
                'descripcion' => '2022-II',
                'inicio_periodo' => '2022/08/25',
                'fin_periodo' => '2022/12/15'
            ]
        ]);
    }
}
