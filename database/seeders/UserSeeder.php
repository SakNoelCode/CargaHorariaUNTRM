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
                'email' => '7494213381@untrm.edu.pe',
                'dni' => '74942133',
                'password' => bcrypt('12345678'),
                'rol_id' => '1'
            ],
            [
                'name' => 'JefeDepartamento',
                'email' => 'jefe@untrm.edu.pe',
                'dni' => '12345678',
                'password' => bcrypt('12345678'),
                'rol_id' => '2'
            ],
            [
                'name' => 'Ivan Adrianzén',
                'email' => 'd1@untrm.edu.pe',
                'dni' => '12344321',
                'password' => bcrypt('12345678'),
                'rol_id' => '3'
            ],
            [
                'name' => 'Carlos Santa Cruz',
                'email' => 'd2@untrm.edu.pe',
                'dni' => '12344326',
                'password' => bcrypt('12345678'),
                'rol_id' => '3'
            ]
        ]);
    }
}
