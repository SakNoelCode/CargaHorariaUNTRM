<?php

namespace App\Http\Livewire\Curso;

use App\Models\Ciclo;
use App\Models\Curso;
use Livewire\Component;

class Create extends Component
{
    public $isOpen = false;
    public $nombreCurso, $tipoCurso, $cicloCurso;

    protected $rules  = [
        'nombreCurso' => 'required|unique:cursos,nombre',
        'tipoCurso' => 'required',
        'cicloCurso' => 'required'
    ];

    public function render()
    {
        $ciclos = Ciclo::all();
        return view('livewire.curso.create', ['ciclos' => $ciclos]);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();
        $curso = Curso::create([
            'nombre' => $this->nombreCurso,
            'tipo' => $this->tipoCurso,
            'ciclo_id' => $this->cicloCurso
        ]);
        $this->closeModal();
        $this->emitTo('curso.show','render');
        $this->emit('alert', 'Curso creado exitosamente');
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetForm()
    {
        $this->reset([
            'nombreCurso', 'tipoCurso', 'cicloCurso'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
