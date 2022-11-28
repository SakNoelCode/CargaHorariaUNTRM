<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Condicione;
use App\Models\Docente;
use App\Models\Escuela;
use App\Models\Modalidade;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;
use Livewire\Component;

class CreateDocente extends Component
{
    public $IsOpen = false;

    //Variables del modelo
    public $name, $email, $dni, $password, $password_confirmation, $rol_id = 3;
    public $escuela_id = '', $condicion_id = '', $categoria_id = '', $modalidad_id = '';

    //validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|max:255|email|unique:users,email',
        'dni' => 'required|string|max:8|min:8|unique:users,dni',
        'password' => 'required|min:6|confirmed',
        'escuela_id' => 'required',
        'condicion_id' => 'required',
        'categoria_id' => 'required',
        'modalidad_id' => 'required'
    ];

    public function render()
    {
        $escuelas = Escuela::all();
        $condiciones = Condicione::all();
        $categorias = Categoria::all();
        $modalidades = Modalidade::all();

        return view(
            'livewire.create-docente',
            [
                'escuelas' => $escuelas,
                'condiciones' => $condiciones,
                'categorias' => $categorias,
                'modalidades' => $modalidades
            ]
        );
    }

    /*Función para validar dinamicamente
    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }*/

    //Función para guardar un docente
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

            $docente = new Docente();
            $docente->escuela_id = $this->escuela_id;
            $docente->condicion_id = $this->condicion_id;
            $docente->categoria_id =  $this->categoria_id;
            $docente->modalidad_id = $this->modalidad_id;
            $docente->user_id = $user->id;
            $docente->save();

            //Confirmar transaccion
            DB::commit();

            //Emitir un evento
            $this->emitTo('show-users', 'render_table_users');
            $this->emit('alert', 'Usuario creado con éxito');
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
            'name', 'email', 'IsOpen', 'dni', 'password', 'password_confirmation',
            'escuela_id', 'condicion_id', 'categoria_id', 'modalidad_id'
        ]);
    }

    public function updatingisOpen()
    {
        if ($this->IsOpen == false) {
            $this->cleanFields();

            //Borrar avisos de validación
            $this->resetErrorBag();
            $this->resetValidation();
        }
    }
}
