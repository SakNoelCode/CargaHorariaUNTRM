<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'nombre' => 'auditoria de sistemas de información',
                'tipo' => 'O'
            ],
            [
                'nombre' => 'gestión del conocimiento',
                'tipo' => 'O'
            ],
            [
                'nombre' => 'gobierno de tecnologías de la información',
                'tipo' => 'O'
            ],
            [
                'nombre' => 'legislación informática',
                'tipo' => 'O'
            ],
            [
                'nombre' => 'marketing digital y comercio electrónico',
                'tipo' => 'O'
            ],
            [
                'nombre' => 'tesis II',
                'tipo' => 'O'
            ],
            [
                'nombre' => 'tesis I',
                'tipo' => 'O'
            ],
            [
                'nombre' => 'administración de servidores de seguridad',
                'tipo' => 'E'
            ],
            [
                'nombre' => 'desarrollo de soluciones en software libre',
                'tipo' => 'O'
            ],
            [
                'nombre' => 'gestión y modelamiento de procesos',
                'tipo' => 'E'
            ]
        ]);
    }
}
