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
        $this->idJefe = $user->jefeDepartamento->id;
    }

    public function asignarValores(){
        $user = User::find($this->idUser);
        $this->name = $user->name;
        $this->dni= $user->dni;
        $this->email = $user->email;
        $this->escuela_id = $user->jefeDepartamento->escuela_id;
        if($user->status == 'ACTIVO'){
            $this->status = true;
        }else{
            $this->status = false;
        }
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
        $this->closeEditJefe();
    }

    public function closeEditJefe()
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
