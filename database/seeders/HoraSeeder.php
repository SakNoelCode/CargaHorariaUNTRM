<?php

namespace Database\Seeders;

use App\Models\Hora;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hora::insert([
            [
                'hora_inicio' => '07:30',
                'hora_fin' => '08:20',
                'sistema_horario' => 'am'
            ],
            [
                'hora_inicio' => '08:20',
                'hora_fin' => '09:10',
                'sistema_horario' => 'am'
            ],
            [
                'hora_inicio' => '09:10',
                'hora_fin' => '10:00',
                'sistema_horario' => 'am'
            ],
            [
                'hora_inicio' => '10:00',
                'hora_fin' => '10:50',
                'sistema_horario' => 'am'
            ],
            [
                'hora_inicio' => '10:50',
                'hora_fin' => '11:40',
                'sistema_horario' => 'am'
            ],
            [
                'hora_inicio' => '11:40',
                'hora_fin' => '12:30',
                'sistema_horario' => 'am'
            ],
            [
                'hora_inicio' => '12:30',
                'hora_fin' => '01:20',
                'sistema_horario' => 'pm'
            ],
            [
                'hora_inicio' => '02:00',
                'hora_fin' => '02:50',
                'sistema_horario' => 'pm'
            ],
            [
                'hora_inicio' => '02:50',
                'hora_fin' => '03:40',
                'sistema_horario' => 'pm'
            ],
            [
                'hora_inicio' => '03:40',
                'hora_fin' => '04:30',
                'sistema_horario' => 'pm'
            ],
            [
                'hora_inicio' => '04:30',
                'hora_fin' => '05:20',
                'sistema_horario' => 'pm'
            ],
            [
                'hora_inicio' => '05:20',
                'hora_fin' => '06:10',
                'sistema_horario' => 'pm'
            ],
            [
                'hora_inicio' => '06:10',
                'hora_fin' => '07:00',
                'sistema_horario' => 'pm'
            ],
            [
                'hora_inicio' => '07:00',
                'hora_fin' => '07:50',
                'sistema_horario' => 'pm'
            ],
            [
                'hora_inicio' => '07:50',
                'hora_fin' => '08:40',
                'sistema_horario' => 'pm'
            ],
            [
                'hora_inicio' => '08:40',
                'hora_fin' => '09:30',
                'sistema_horario' => 'pm'
            ]
        ]);
    }
}
