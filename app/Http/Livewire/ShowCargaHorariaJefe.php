<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ShowCargaHorariaJefe extends Component
{
    //Importaciones
    use WithPagination;

    //Variables
    public $registros = "5";

    public function render()
    {
        $departamentoJefe = auth()->user()->jefeDepartamento->escuela->id;
        $cargas = DB::table('carga_lectivas as cl')
            ->join('declaracion_juradas as dj', 'dj.id', 'cl.declaracionJurada_id')
            ->join('periodos as p','p.id','dj.periodo_id')
            ->join('docentes as d','d.id','dj.docente_id')
            ->join('users as u','u.id','d.user_id')
            ->join('escuelas as e','e.id','d.escuela_id')
            ->select('cl.id','e.id as escuela_id','u.name as nameDocente','p.descripcion as periodo','cl.estado_asignado')
            ->where('escuela_id',$departamentoJefe)
            ->orderBy('cl.id')
            ->paginate($this->registros);

        return view('livewire.show-carga-horaria-jefe', compact('cargas'));
    }

    //Para evitar el bug de no existencia de cargas horarias
    public function updatingRegistros()
    {
        $this->resetPage();
    }
}
