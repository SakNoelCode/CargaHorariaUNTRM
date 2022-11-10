<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            ['descripcion' => 'administrador'],
            ['descripcion' => 'jefe departamento'],
            ['descripcion' => 'docente']
        ]);
    }
}
