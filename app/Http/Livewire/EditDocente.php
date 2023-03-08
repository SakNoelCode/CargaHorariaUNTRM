<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Condicione;
use App\Models\Escuela;
use App\Models\Docente;
use App\Models\Modalidade;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Exception;

class EditDocente extends Component
{
    public $IsOpen = false;

    public $idUser, $idDocente, $name, $dni, $email;
    public $escuela_id, $condicion_id, $categoria_id, $modalidad_id;
    public $status;

    //validation rules
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|max:255|email|unique:users,email,' . $this->idUser,
            'dni' => 'required|string|min:8|max:8|unique:users,dni,' . $this->idUser,
            'escuela_id' => 'required',
            'condicion_id' => 'required',
            'categoria_id' => 'required',
            'modalidad_id' => 'required'
        ];
    }

    //Atributos personalizados
    protected $validationAttributes = [
        'name' => 'nombres',
        'dni' => 'DNI',
        'email' => 'correo eléctronico',
        'escuela_id' => 'escuela',
        'condicion_id' => 'condicion',
        'categoria_id' => 'categoría',
        'modalidad_id' => 'modalidad'
    ];

    //Constructor
    public function mount($id)
    {
        $user = User::find($id);
        $this->idUser = $user->id;
        $this->idDocente = $user->docente->id;
    }

    //Asiganr los valores originales a los modelos que se van a mostrar en la vista
    public function asignarValores()
    {
        $user = User::findOrfail($this->idUser);

        $this->name = $user->name;
        $this->dni = $user->dni;
        $this->email = $user->email;
        $this->escuela_id = $user->docente->escuela_id;
        $this->condicion_id = $user->docente->condicion_id;
        $this->categoria_id = $user->docente->categoria_id;
        $this->modalidad_id = $user->docente->modalidad_id;

        if ($user->status == 'ACTIVO') {
            $this->status = true;
        } else {
            $this->status = false;
        }
    }

    public function render()
    {
        //Load the Componentes
        $escuelas = Escuela::all();
        $condiciones = Condicione::all();
        $categorias = Categoria::all();
        $modalidades = Modalidade::all();

        return view('livewire.edit-docente', [
            'escuelas' => $escuelas,
            'condiciones' => $condiciones,
            'categorias' => $categorias,
            'modalidades' => $modalidades
        ]);
    }

    public function save()
    {
        $this->validate();
        try {
            //Iniciar transaccion
            DB::beginTransaction();
            $user = User::findOrfail($this->idUser);
            $user->name = $this->name;
            $user->email = $this->email;
            $user->dni = $this->dni;
            if ($this->status) {
                $user->status = 'ACTIVO';
            } else {
                $user->status = 'INACTIVO';
            }
            $user->update();

            $docente = Docente::findOrfail($this->idDocente);
            $docente->escuela_id = $this->escuela_id;
            $docente->condicion_id = $this->condicion_id;
            $docente->categoria_id =  $this->categoria_id;
            $docente->modalidad_id = $this->modalidad_id;
            $docente->update();

            //Confirmar transaccion
            DB::commit();

            //Emitir un evento
            $this->emitTo('show-users', 'render_table_users');
            $this->emit('alert', 'Usuario modificado con éxito');
        } catch (Exception $e) {
            //revertir transaccion
            DB::rollBack();
        }

        //Clean Fields
        $this->closeEditDocente();
    }

    public function closeEditDocente()
    {
        $this->reset([
            'IsOpen'
        ]);
    }

    public function updatingisOpen()
    {
        if ($this->IsOpen == false) {

            $this->asignarValores();
            //Borrar avisos de validación
            $this->resetErrorBag();
            $this->resetValidation();
        }
    }
}
