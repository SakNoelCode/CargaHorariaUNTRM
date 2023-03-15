<?php

namespace App\Http\Livewire\Curso;

use App\Models\Ciclo;
use App\Models\Curso;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    public $numRegistros = 5;
    public $search = '';
    public $isOpenEdit = false;
    public $idCurso, $nameCurso, $tipoCurso, $estadoCurso, $cicloId;

    protected $listeners = ['render'];

    protected function rules()
    {
        return [
            'nameCurso' => 'required|unique:cursos,nombre,' . $this->idCurso,
            'tipoCurso' => 'required',
            'cicloId' => 'required'
        ];
    }

    public function render()
    {
        $cursos = Curso::with('ciclo')
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->paginate($this->numRegistros);

        $ciclos = Ciclo::all();

        return view('livewire.curso.show', compact('cursos', 'ciclos'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingNumRegistros()
    {
        $this->resetPage();
    }

    public function edit(Curso $item)
    {
        $this->resetValidationFormEdit();
        $this->idCurso = $item->id;
        $this->nameCurso = $item->nombre;
        $this->tipoCurso = $item->tipo;
        $this->estadoCurso = $item->estado == 1 ? true : false;
        $this->cicloId = $item->ciclo_id;
        $this->isOpenEdit = true;
    }

    public function update()
    {
        $this->validate();

        Curso::where('id', $this->idCurso)
            ->update([
                'nombre' =>  strtolower($this->nameCurso),
                'tipo' => $this->tipoCurso,
                'estado' => $this->estadoCurso == true ? 1 : 0,
                'ciclo_id' => $this->cicloId
            ]);
        $this->closeEdit();
        $this->emit('alert', 'curso actualizado exitosamente');
    }

    public function closeEdit()
    {
        $this->isOpenEdit = false;
    }

    public function resetValidationFormEdit()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function getEstado($estado)
    {
        return $estado == true ? 1 : 0;
    }
}
