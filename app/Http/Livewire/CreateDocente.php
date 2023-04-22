<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Condicione;
use App\Models\Docente;
use App\Models\Escuela;
use App\Models\Especialidade;
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
    public $escuela_id = '', $condicion_id = '', $categoria_id = '', $modalidad_id = '', $especialidades_id;
    public $arrayEspecialidades;

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

    protected $validationAttributes = [
        'name' => 'nombre',
        'dni' => 'DNI',
        'email' => 'correo electrónico',
        'escuela_id' => 'escuela',
        'condicion_id' => 'condición',
        'categoria_id' => 'categoría',
        'modalidad_id' => 'modalidad',
        'password' => 'contraseña'
    ];

    protected $listeners = ['listenerReferenceEspecialidades'];

    public function render()
    {
        $escuelas = Escuela::all();
        $condiciones = Condicione::all();
        $categorias = Categoria::all();
        $modalidades = Modalidade::all();
        $especialidades = Especialidade::all();
        $this->arrayEspecialidades = Especialidade::all()->toArray();

        return view(
            'livewire.create-docente',
            [
                'escuelas' => $escuelas,
                'condiciones' => $condiciones,
                'categorias' => $categorias,
                'modalidades' => $modalidades,
                'especialidades' => $especialidades
            ]
        );
    }

    //Función para guardar un docente
    public function save()
    {
        if ($this->especialidades_id != null) {
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

                $docente->especialidades()->attach($this->especialidades_id);

                //Confirmar transaccion
                DB::commit();

                //Emitir un evento
                $this->emitTo('show-users', 'render_table_users');
                $this->emit('alert', 'Usuario creado con éxito');
            } catch (Exception $e) {
                dd($e);
                //revertir transaccion
                DB::rollBack();
            }

            //Clean Fields
            $this->cleanFields();
        } else {
            $this->emit('alertMixin', 'error', 'Validaciones incorrectas');
        }
    }

    //Limpiar campos
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
            //dd('Ola');
            $this->cleanFields();

            //Borrar avisos de validación
            $this->resetErrorBag();
            $this->resetValidation();

            //Lanzar evento liveware al Fronted cuando el modal se quiera abrir
            $this->emit('openModal');
        }
    }

    public function listenerReferenceEspecialidades($selectedValue)
    {
        $this->especialidades_id = $selectedValue;
    }
}
