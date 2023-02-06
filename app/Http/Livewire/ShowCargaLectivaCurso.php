<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowCargaLectivaCurso extends Component
{

    public $cargaLectivaId;
    public $isOpenModalDelete = false;
    public $deleteId;

    protected $listeners = ['render_table_carga_lectiva_curso'=>'render'];

    public function mount($id)
    {
        $this->cargaLectivaId = $id;
    }

    public function render()
    {
        $cursosAsignados = DB::table('cargalectiva_curso as clc')
            ->join('cursos as c', 'c.id', '=', 'clc.curso_id')
            ->join('ciclos as ci','ci.id','=','clc.ciclo_id')
            ->join('seccions as s','s.id','=','clc.seccion_id')
            ->select('clc.id as id','c.nombre as nombreCurso','ci.descripcion as descripcionCiclo','s.descripcion as descripcionSeccion')
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->get();

        /*foreach ($cursosAsignados as $item) {
            dd($item->nombre);
        }*/

        return view('livewire.show-carga-lectiva-curso', ['cursosAsignados' => $cursosAsignados]);
    }

    public function deleteId($id){
        $this->deleteId = $id;
        $this->isOpenModalDelete = true;
    }

    public function delete(){
        $cursoAsignado =  DB::table('cargalectiva_curso')
        ->where('id','=',$this->deleteId)
        ->delete();        
        $this->isOpenModalDelete = false;
        $this->emit('alertMixin', 'success', 'Curso eliminado exitosamente');
    }
}
