<?php

namespace App\Http\Livewire;

use App\Models\CargaLectiva;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowCargaLectivaCurso extends Component
{

    public $cargaLectivaId, $estadoCargaLectiva;
    public $isOpenModalDelete = false;
    public $isOpenmodaledit = false;
    public $deleteId;
    public $isDocente;

    //Variables para editar curso
    public $idCurso;
    public $numAlumnos, $horasTeoria, $horasPractica;

    protected $rules = [
        'numAlumnos' => 'required',
        'horasTeoria' => 'required',
        'horasPractica' => 'required'

    ];

    protected $listeners = ['render_table_carga_lectiva_curso' => 'render'];

    public function mount($id, $isDocente)
    {
        $this->cargaLectivaId = $id;
        $this->estadoCargaLectiva = CargaLectiva::find($id)->estado_asignado;
        $this->isDocente = $isDocente;
    }

    public function render()
    {
        $cursosAsignados = DB::table('cargalectiva_curso as clc')
            ->join('cursos as c', 'c.id', '=', 'clc.curso_id')
            ->join('ciclos as ci', 'ci.id', '=', 'clc.ciclo_id')
            ->join('seccions as s', 's.id', '=', 'clc.seccion_id')
            ->select('clc.id as id', 'c.nombre as nombreCurso', 'ci.descripcion as descripcionCiclo', 's.descripcion as descripcionSeccion')
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->get();

        /*foreach ($cursosAsignados as $item) {
            dd($item->nombre);
        }*/

        return view('livewire.show-carga-lectiva-curso', ['cursosAsignados' => $cursosAsignados]);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
        $this->isOpenModalDelete = true;
    }

    public function delete()
    {
        $cursoAsignado =  DB::table('cargalectiva_curso')
            ->where('id', '=', $this->deleteId)
            ->delete();
        $this->isOpenModalDelete = false;
        $this->emit('alertMixin', 'success', 'Curso eliminado exitosamente');
    }

    public function edit($id)
    {
        $this->idCurso = $id;
        $this->isOpenmodaledit = true;
    }

    public function close()
    {
        $this->isOpenmodaledit = false;
    }

    public function update()
    {
        $this->validate();
    }

    public function resetFormEdit()
    {
        $this->reset([
            'numAlumnos',
            'horasTeoria',
            'horasPractica'
        ]);
    }

    public function updatingIsOpenmodaledit()
    {
        if ($this->isOpenmodaledit == false) {
            dd('maldita sea');
        }
    }
}
