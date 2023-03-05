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
                'descripcion' => '2023-I',
                'inicio_periodo' => '2023/04/06',
                'fin_periodo' => '2023/06/15'
            ],
            [
                'descripcion' => '2023-II',
                'inicio_periodo' => '2023/08/03',
                'fin_periodo' => '2023/12/21'
            ],
            [
                'descripcion' => '2024-I',
                'inicio_periodo' => '2024-04-12',
                'fin_periodo' => '2024-06-28'
            ],
            [
                'descripcion' => '2024-II',
                'inicio_periodo' => '2024-08-05',
                'fin_periodo' => '2024-12-23'
            ]
        ]);
    }
}
