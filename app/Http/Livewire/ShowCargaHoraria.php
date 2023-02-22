<?php

namespace App\Http\Livewire;

use App\Models\Carga;
use Illuminate\Support\Facades\DB;
use App\Models\CargaHoraria;
use App\Models\Curso;
use Livewire\Component;


class ShowCargaHoraria extends Component
{
    public $cargaLectivaId, $cargaHorariaId;
    public $totalHoras = 0;

    //Variables para eliminar detalle
    public $idDelete, $isOpenModalDelete = false;

    public function mount($id)
    {
        $cargaHoraria = CargaHoraria::where('cargalectiva_id', '=', $id)
            ->first();

        $this->cargaLectivaId = $id;
        $this->cargaHorariaId = $cargaHoraria->id;
    }

    public function render()
    {
        //Bug por solucionar: Los días de la semana deben ser números, de esa manera
        //es más facil poder ordenarlos

        $detalle_carga_horaria = DB::table('detalle_carga_horaria as dch')
            ->select(
                'dch.id as idDetalle',
                'dch.dia',
                'h.id',
                'h.hora_inicio',
                'hf.hora_fin',
                'h.sistema_horario',
                'dch.cargalectiva_carga_id',
                'dch.cargalectiva_curso_id',
                'a.descripcion as descripcionAula',
                'l.descripcion as descripcionLocal',
                'dch.tipo',
                'dch.hora_inicio_id',
                'dch.hora_fin_id'
            )
            ->join('horas as h', 'h.id', 'dch.hora_inicio_id')
            ->join('horas as hf', 'hf.id', 'dch.hora_fin_id')
            ->join('aulas as a', 'a.id', 'dch.aula_id')
            ->join('locals as l', 'l.id', 'a.local_id')
            ->where('cargahoraria_id', '=', $this->cargaHorariaId)
            ->orderBy('dch.dia', 'asc')
            ->orderBy('h.id', 'asc')
            ->get();

        $cargas = DB::table('cargalectiva_carga as clc')
            ->select('clc.id', 'c.titulo')
            ->join('cargas as c', 'c.id', 'clc.carga_id')
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->get();

        $cursos = DB::table('cargalectiva_curso as clc')
            ->select('clc.id', 'c.nombre')
            ->join('cursos as c', 'c.id', 'clc.curso_id')
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->get();

        return view('livewire.show-carga-horaria', compact('detalle_carga_horaria', 'cargas', 'cursos'));
    }

    public function close()
    {
        $this->isOpenModalDelete = false;
    }

    public function deleteId($id)
    {
        $this->idDelete = $id;
        $this->isOpenModalDelete = true;
    }

    public function delete()
    {
        $detalle =  DB::table('detalle_carga_horaria')
            ->where('id', '=', $this->idDelete)
            ->delete();

        $this->isOpenModalDelete = false;
        $this->emit('alertMixin', 'success', 'Registro eliminado exitosamente');
    }
}
