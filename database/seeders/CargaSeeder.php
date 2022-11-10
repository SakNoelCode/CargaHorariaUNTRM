<?php

namespace Database\Seeders;

use App\Models\Carga;
use Illuminate\Database\Seeder;

class CargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carga::insert([
            [
                'titulo' => 'preparacion y evaluación del aprendizaje',
                'descripcion' => '(50% del trabajo lectivo)'
            ],
            [
                'titulo' => 'consejeria',
                'descripcion' => 'Señalar número y escuela Academico Profesional de los alumnos.'
            ],
            [
                'titulo' => 'investigación',
                'descripcion' => 'Consignar el código, nombre y duración del Proyecto, así como el ambiente en el que se desarrolla el mismo.'
            ],
            [
                'titulo' => 'gobierno y administración',
                'descripcion' => 'Indicar si desempeña cargo en la UNTRM.'
            ],
            [
                'titulo' => 'administración curricular',
                'descripcion' => 'Indicar en que cursos, programas, etc.'
            ],
            [
                'titulo' => 'producción de bienes y servicios',
                'descripcion' => 'Indicar actividades programadas.'
            ],
            [
                'titulo' => 'capacitación',
                'descripcion' => 'Señalar el programa o evento en concordancia con los planes de la Facultad.'
            ],
            [
                'titulo' => 'proyección social',
                'descripcion' => 'Señalar la actividad o programa.'
            ],
            [
                'titulo' => 'asesoramiento de tesis y trabajos profesionales',
                'descripcion' => 'Indicar el nombre y duración.'
            ],
            [
                'titulo' => 'exámenes profesionales',
                'descripcion' => 'Señalar número o frecuencia y luego anote horas promedio.'
            ],
            [
                'titulo' => 'comisiones',
                'descripcion' => 'Consignar datos completos sobre designación y duración de la misma.'
            ]
        ]);
    }
}
