<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use App\Models\Curso;
use App\Models\Seccion;
use Livewire\Component;

class AsignarCurso extends Component
{
    //Variables
    public $isOpen = false;
    public $cursoId, $cicloId, $seccionId, $cargaLectivaId, $escuelaId;
    public $arrayCursos;

    protected $listeners = ['listenerReferenceCurso', 'listenerReferenceSeccion'];

    public function mount($id, $idEscuela)
    {
        $this->cargaLectivaId = $id;
        $this->escuelaId = $idEscuela;
    }

    public function render()
    {
        //Hacer consulta de los cursos que tiene la carga lectiva y transformarlas en array
        $cursosCargaLectiva = DB::table('carga_lectivas as cl')
            ->join('cargalectiva_curso as clc', 'cl.id', '=', 'clc.cargalectiva_id')
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->pluck('curso_id')->toArray();
        
        $cursosDesactivados = Curso::where('estado',0)->get();
        $arrayCursosDesactivados = array();
        foreach($cursosDesactivados as $c){
            $arrayCursosDesactivados[] = $c->id;
        }

        $cursos = Curso::all()->except($cursosCargaLectiva)->except($arrayCursosDesactivados);
        //$ciclos = Ciclo::all();
        $secciones = Seccion::all();

        $this->arrayCursos = $cursos->pluck('nombre','id')->toArray();
        
        return view('livewire.asignar-curso', compact('cursos', 'secciones'));
    }

    public function listenerReferenceCurso($selectedValue)
    {
        $this->cursoId = $selectedValue;
    }
    /*
    public function listenerReferenceCiclo($selectedValue)
    {
        $this->cicloId = $selectedValue;
    }*/
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
        //Validaciones
        if ($this->cursoId != null && $this->seccionId != null) {

            $curso = Curso::find($this->cursoId);
            
            DB::table('cargalectiva_curso')->insert([
                'cargalectiva_id' => $this->cargaLectivaId,
                'curso_id' => $this->cursoId,
                'escuela_id' => $this->escuelaId,
                'seccion_id' => $this->seccionId,
                'ciclo_id' => $curso->ciclo->id
            ]);

            $this->closeModal();

           // $this->emitTo('render', 'renderModal');
            $this->emitTo('show-carga-lectiva-curso','render_table_carga_lectiva_curso');
            $this->emit('alertMixin', 'success', 'Curso asignado exitosamente');
        } else {
            $this->emit('alertMixin', 'error', 'validaciones incorrectas');
        }
    }

    //Lanzar evento liveware al Fronted cuando el modal se quiera abrir
    public function updatingIsOpen()
    {
        if ($this->isOpen == false) {
            $this->emit('openModal');
        }
    }
}
