<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Curso::insert([
            [
                'nombre' => 'economía general',
                'tipo' => 'O',
                'ciclo_id' => 1,
                'especialidad_id' => 8
            ],
            [
                'nombre' => 'fundamentos de programación',
                'tipo' => 'O',
                'ciclo_id' => 1,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'introducción a la ingeniería de sistemas',
                'tipo' => 'O',
                'ciclo_id' => 1,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'lenguaje y comunicación',
                'tipo' => 'O',
                'ciclo_id' => 1,
                'especialidad_id' => 4
            ],
            [
                'nombre' => 'matemática básica',
                'tipo' => 'O',
                'ciclo_id' => 1,
                'especialidad_id' => 3
            ],
            [
                'nombre' => 'metodología para el trabajo universitario',
                'tipo' => 'O',
                'ciclo_id' => 1,
                'especialidad_id' => 5
            ],
            [
                'nombre' => 'cálculo diferencial',
                'tipo' => 'O',
                'ciclo_id' => 2,
                'especialidad_id' => 3
            ],
            [
                'nombre' => 'constitución y derechos humanos',
                'tipo' => 'O',
                'ciclo_id' => 2,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'contabilidad general',
                'tipo' => 'O',
                'ciclo_id' => 2,
                'especialidad_id' => 8
            ],
            [
                'nombre' => 'estructura de datos y de la información',
                'tipo' => 'O',
                'ciclo_id' => 2,
                'especialidad_id' => 2
            ],
            [
                'nombre' => 'realidad nacional y mundial',
                'tipo' => 'O',
                'ciclo_id' => 2,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'redacción',
                'tipo' => 'O',
                'ciclo_id' => 2,
                'especialidad_id' => 4
            ],
            [
                'nombre' => 'cálculo integral',
                'tipo' => 'O',
                'ciclo_id' => 3,
                'especialidad_id' => 3
            ],
            [
                'nombre' => 'costos y presupuestos',
                'tipo' => 'O',
                'ciclo_id' => 3,
                'especialidad_id' => 8
            ],
            [
                'nombre' => 'estadística general',
                'tipo' => 'O',
                'ciclo_id' => 3,
                'especialidad_id' => 11
            ],
            [
                'nombre' => 'física general',
                'tipo' => 'O',
                'ciclo_id' => 3,
                'especialidad_id' => 7
            ],
            [
                'nombre' => 'fundamentos de base de datos',
                'tipo' => 'O',
                'ciclo_id' => 3,
                'especialidad_id' => 2
            ],
            [
                'nombre' => 'metodología de la programación',
                'tipo' => 'O',
                'ciclo_id' => 3,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'administración empresarial',
                'tipo' => 'O',
                'ciclo_id' => 4,
                'especialidad_id' => 8
            ],
            [
                'nombre' => 'base de datos avanzada',
                'tipo' => 'O',
                'ciclo_id' => 4,
                'especialidad_id' => 2
            ],
            [
                'nombre' => 'desarrollo de aplicaciones web I',
                'tipo' => 'O',
                'ciclo_id' => 4,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'estadística aplicada',
                'tipo' => 'O',
                'ciclo_id' => 4,
                'especialidad_id' => 11
            ],
            [
                'nombre' => 'investigación de operaciones I',
                'tipo' => 'O',
                'ciclo_id' => 4,
                'especialidad_id' => 3
            ],
            [
                'nombre' => 'taller de programación I',
                'tipo' => 'O',
                'ciclo_id' => 4,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'circuitos eléctricos y electrónicos',
                'tipo' => 'O',
                'ciclo_id' => 5,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'desarrollo de aplicaciones web II',
                'tipo' => 'O',
                'ciclo_id' => 5,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'ingeniería de software I',
                'tipo' => 'O',
                'ciclo_id' => 5,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'investigación de operaciones II',
                'tipo' => 'O',
                'ciclo_id' => 5,
                'especialidad_id' => 3
            ],
            [
                'nombre' => 'taller de programación II',
                'tipo' => 'O',
                'ciclo_id' => 5,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'teoría general de sistemas',
                'tipo' => 'O',
                'ciclo_id' => 5,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'arquitectura de computadoras',
                'tipo' => 'O',
                'ciclo_id' => 6,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'dinámica de sistemas',
                'tipo' => 'O',
                'ciclo_id' => 6,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'ingeniería de software II',
                'tipo' => 'O',
                'ciclo_id' => 6,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'inteligencia de negocios',
                'tipo' => 'O',
                'ciclo_id' => 6,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'programación de aplicaciones móviles',
                'tipo' => 'O',
                'ciclo_id' => 6,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'teoría de decisiones',
                'tipo' => 'O',
                'ciclo_id' => 6,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'redes y conectividad I',
                'tipo' => 'O',
                'ciclo_id' => 7,
                'especialidad_id' => 6
            ],
            [
                'nombre' => 'administración de servidores',
                'tipo' => 'E',
                'ciclo_id' => 7,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'inteligencia artificial y robótica',
                'tipo' => 'O',
                'ciclo_id' => 7,
                'especialidad_id' => 10
            ],
            [
                'nombre' => 'metodología de la investigación científica',
                'tipo' => 'O',
                'ciclo_id' => 7,
                'especialidad_id' => 5
            ],
            [
                'nombre' => 'sistemas distribuidos',
                'tipo' => 'O',
                'ciclo_id' => 7,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'sistemas operativos',
                'tipo' => 'O',
                'ciclo_id' => 7,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'redes y conectividad II',
                'tipo' => 'O',
                'ciclo_id' => 8,
                'especialidad_id' => 6
            ],
            [
                'nombre' => 'administración de servidores de infraestructura',
                'tipo' => 'O',
                'ciclo_id' => 8,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'formulación y evaluación de proyectos de TI',
                'tipo' => 'O',
                'ciclo_id' => 8,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'gestión de servicios de TI',
                'tipo' => 'O',
                'ciclo_id' => 8,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'planeamiento estratégico de TI',
                'tipo' => 'O',
                'ciclo_id' => 8,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'prueba y calidad de software',
                'tipo' => 'O',
                'ciclo_id' => 8,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'tesis I',
                'tipo' => 'O',
                'ciclo_id' => 9,
                'especialidad_id' => 5
            ],
            [
                'nombre' => 'administración de servidores de seguridad II',
                'tipo' => 'E',
                'ciclo_id' => 9,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'desarrollo de soluciones en software libre',
                'tipo' => 'O',
                'ciclo_id' => 9,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'gestión de proyectos de TI',
                'tipo' => 'O',
                'ciclo_id' => 9,
                'especialidad_id' => 1
            ],
            [
                'nombre' => 'seguridad infórmatica',
                'tipo' => 'O',
                'ciclo_id' => 9,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'sistemas integrados de gestión ERP',
                'tipo' => 'O',
                'ciclo_id' => 9,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'auditoría de sistemas de información',
                'tipo' => 'O',
                'ciclo_id' => 10,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'gestión del conocimiento',
                'tipo' => 'O',
                'ciclo_id' => 10,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'gobierno de tecnologías de la información',
                'tipo' => 'O',
                'ciclo_id' => 10,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'legislación infórmatica',
                'tipo' => 'O',
                'ciclo_id' => 10,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'marketing digital y comercio eléctronico',
                'tipo' => 'O',
                'ciclo_id' => 10,
                'especialidad_id' => 9
            ],
            [
                'nombre' => 'Tesis II',
                'tipo' => 'O',
                'ciclo_id' => 10,
                'especialidad_id' => 5
            ]
        ]);
    }
}
