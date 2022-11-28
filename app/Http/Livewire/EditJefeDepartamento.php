<?php

namespace App\Http\Livewire;

use App\Models\Escuela;
use App\Models\JefeDepartamento;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;
use Livewire\Component;

class EditJefeDepartamento extends Component
{
    public $originalName,$originalDni,$originalEmail,$originalEscuelaId,$originalStatus=false;
    public $isOpen = false;
    public $idUser, $idJefe, $name, $dni, $email, $status;
    public $escuela_id;

    //validation rules
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|max:255|email|unique:users,email,' . $this->idUser,
            'dni' => 'required|string|max:8|min:8|unique:users,dni,' . $this->idUser,
            'escuela_id' => 'required|unique:jefe_departamentos,escuela_id,' . $this->idJefe
        ];
    }

    //Constructor
    public function mount($id)
    {
        $user = User::find($id);
        $this->idUser = $user->id;
        $this->originalName = $user->name;
        $this->originalDni = $user->dni;
        $this->originalEmail = $user->email;
        $this->idJefe = $user->jefeDepartamento->id;
        $this->originalEscuelaId = $user->jefeDepartamento->escuela_id;

        if ($user->status == 'ACTIVO') {
            $this->originalStatus = true;
        }

        $this->asignarValores();
    }

    public function asignarValores(){
        $this->name = $this->originalName;
        $this->dni= $this->originalDni;
        $this->email = $this->originalEmail;
        $this->escuela_id = $this->originalEscuelaId;
        $this->status = $this->originalStatus;
    }

    public function render()
    {
        $escuelas = Escuela::all();
        return view('livewire.edit-jefe-departamento', compact('escuelas'));
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

            $jefe = JefeDepartamento::findOrfail($this->idJefe);
            $jefe->escuela_id = $this->escuela_id;
            $jefe->update();

            //Confirmar transaccion
            DB::commit();

            //Emitir un evento
            $this->emitTo('show-users', 'render_table_users');
            $this->emit('alert', 'jefe modificado con éxito');
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
            'isOpen'
        ]);
    }

    public function updatingIsOpen()
    {
        if ($this->isOpen == false) {
            $this->asignarValores();
            //Borrar avisos de validación
            $this->resetErrorBag();
            $this->resetValidation();
        }
    }
}
