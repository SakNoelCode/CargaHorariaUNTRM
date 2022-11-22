<?php

namespace App\Http\Livewire;

use App\Models\Escuela;
use App\Models\JefeDepartamento;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

use Livewire\Component;

class CreateJefeDepartamento extends Component
{
    public $isOpen = false;
    public $name, $dni, $email, $password, $password_confirmation, $rol_id = 2;
    public $escuela_id = '';

    //validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|max:255|email|unique:users,email',
        'dni' => 'required|string|max:8|min:8|unique:users,dni',
        'password' => 'required|min:6|confirmed',
        'escuela_id' => 'required|unique:jefe_departamentos,escuela_id'
    ];

    public function render()
    {
        $escuelas = Escuela::all();
        return view('livewire.create-jefe-departamento', compact('escuelas'));
    }

    public function save()
    {
        $this->validate();
        try {
            //Iniciar transaccion
            DB::beginTransaction();
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->dni = $this->dni;
            $user->password = bcrypt($this->password);
            $user->rol_id  = $this->rol_id;
            $user->save();

            $jefe = new JefeDepartamento();
            $jefe->escuela_id = $this->escuela_id;
            $jefe->user_id = $user->id;
            $jefe->save();

            //Confirmar transaccion
            DB::commit();

            //Emitir un evento
            $this->emitTo('show-users', 'render_table_users');
            $this->emit('alert', 'Jefe creado con éxito');
        } catch (Exception $e) {
            //revertir transaccion
            DB::rollBack();
        }

        //Clean Fields
        $this->cleanFields();
    }

    public function cleanFields()
    {
        $this->reset([
            'name', 'email', 'isOpen', 'dni', 'password', 'password_confirmation',
            'escuela_id'
        ]);
    }
}
