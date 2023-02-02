<?php

namespace App\Http\Livewire;

use App\Models\CargaLectiva;
use Illuminate\Support\Facades\DB;
use App\Models\Ciclo;
use App\Models\Curso;
use App\Models\Seccion;
use Livewire\Component;

class AsignarCurso extends Component
{
    //Variables
    public $isOpen = false;
    public $cursoId, $cicloId, $seccionId, $cargaLectivaId, $escuelaId;

    protected $listeners = ['listenerReferenceCurso', 'listenerReferenceCiclo', 'listenerReferenceSeccion'];

    public function mount($id, $idEscuela)
    {
        $this->cargaLectivaId = $id;
        $this->escuelaId = $idEscuela;
    }

    public function render()
    {
        $cursos = Curso::all();
        $ciclos = Ciclo::all();
        $secciones = Seccion::all();

        return view('livewire.asignar-curso', compact('cursos', 'ciclos', 'secciones'));
    }

    public function listenerReferenceCurso($selectedValue)
    {
        $this->cursoId = $selectedValue;
    }
    public function listenerReferenceCiclo($selectedValue)
    {
        $this->cicloId = $selectedValue;
    }
    public function listenerReferenceSeccion($selectedValue)
    {
        $this->seccionId = $selectedValue;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function save()
    {
        if ($this->cursoId != null && $this->cicloId != null && $this->seccionId != null) {

            DB::table('cargalectiva_curso')->insert([
                'cargalectiva_id' => $this->cargaLectivaId,
                'curso_id' => $this->cursoId,
                'escuela_id' => $this->escuelaId,
                'seccion_id' => $this->seccionId,
                'ciclo_id' => $this->cicloId
            ]);

            $this->closeModal();

            $this->emit('alertMixin', 'success', 'Curso asignado exitosamente');
        } else {
            $this->emit('alertMixin', 'error', 'validaciones incorrectas');
        }
    }
}
