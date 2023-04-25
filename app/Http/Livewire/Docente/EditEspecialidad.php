<?php

namespace App\Http\Livewire\Docente;

use App\Models\Docente;
use App\Models\Especialidade;
use App\Models\User;
use Livewire\Component;

class EditEspecialidad extends Component
{
    public $isOpen = false;
    public $docente_id,$docente_name;
    public $especialidadesActuales = [], $nuevasEspecialidades = [];

    //validation rules
    protected function rules()
    {
        return [
            'nuevasEspecialidades' => 'required|array|max:3',
        ];
    }

    protected $messages = [
        'nuevasEspecialidades.required' => 'Debe seleccionar al menos una especialidad',
        'nuevasEspecialidades.max' => 'No puedes seleccionar más de 3 especialidades',
    ];

    //Constructor
    public function mount($id)
    {
        $user = User::find($id);
        $this->docente_id = $user->docente->id;
        $this->docente_name = $user->name;
        $especialidades = $user->docente->especialidades;

        foreach ($especialidades as $i) {
            $this->especialidadesActuales[] = ucfirst($i->descripcion);
        }
    }

    public function render()
    {
        $especialidades = Especialidade::all();
        //dd($especialidades);
        return view('livewire.docente.edit-especialidad', [
            'especialidades' => $especialidades
        ]);
    }

    public function save()
    {
        $this->validate();

        $docente = Docente::find($this->docente_id);

        $docente->especialidades()->sync($this->nuevasEspecialidades);

        $this->closeModal();

        $this->emitTo('show-users', 'render_table_users');
        $this->emit('alert', 'Especialidades de usuario actualizadas');
    }

    public function closeModal()
    {
        $this->reset([
            'isOpen',
            'nuevasEspecialidades'
        ]);
    }

    public function updatingIsOpen()
    {
        if ($this->isOpen == false) {
            $this->reset([
                'nuevasEspecialidades'
            ]);

            //Borrar avisos de validación
            $this->resetErrorBag();
            $this->resetValidation();
        }
    }
}
