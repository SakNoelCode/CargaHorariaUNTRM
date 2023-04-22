<?php

namespace App\Http\Livewire;

use App\Models\CargaLectiva;
use Illuminate\Support\Facades\DB;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Seccion;
use Livewire\Component;

class AsignarCurso extends Component
{
    //Variables
    public $isOpen = false;
    public $cursoId, $cicloId, $seccionId, $cargaLectivaId, $escuelaId;
    public $arrayCursos,$arrayEspecialidadesDocente = [];

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

        //Obtener los id de las especialidades del docente
        $docente_id = CargaLectiva::find($this->cargaLectivaId)->declaracionJurada->docente->id;
        $docente = Docente::with('especialidades')->where('id', $docente_id)->get();
        foreach ($docente as $item) {
            foreach($item->especialidades as $e){
                $this->arrayEspecialidadesDocente[] = $e->id;
            }
        }

        //Obtener los cursos desactivados
        $cursosDesactivados = Curso::where('estado', 0)->get();
        $arrayCursosDesactivados = array();
        foreach ($cursosDesactivados as $c) {
            $arrayCursosDesactivados[] = $c->id;
        }

        //Seleccionar solos los cursos que el el docente tenga como especialidad
        $cursosEspecialidad = Curso::wherein('especialidad_id',$this->arrayEspecialidadesDocente)->get();    

        //Obtener los cursos
        $cursos = $cursosEspecialidad->except($cursosCargaLectiva)->except($arrayCursosDesactivados);
        //$ciclos = Ciclo::all();
        $secciones = Seccion::all();

        $this->arrayCursos = $cursos->pluck('nombre', 'id')->toArray();

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
            $this->emitTo('show-carga-lectiva-curso', 'render_table_carga_lectiva_curso');
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
