<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ROL
        //1 -> administrador
        //2 -> jefe departamento
        //3 -> docente

        User::insert([
            [
                'name' => 'Arcangel',
                'email' => '7494215681@untrm.edu.pe',
                'dni' => '74942156',
                'password' => bcrypt('12345678'),
                'rol_id' => '1'
            ],
            [
                'name' => 'JefeDepartamento',
                'email' => 'jefedepartamento@untrm.edu.pe',
                'dni' => '12345678',
                'password' => bcrypt('12345678'),
                'rol_id' => '2'
            ],
            [
                'name' => 'Docente',
                'email' => 'docente@untrm.edu.pe',
                'dni' => '12345678',
                'password' => bcrypt('12345678'),
                'rol_id' => '3'
            ]
        ]);
    }
}
