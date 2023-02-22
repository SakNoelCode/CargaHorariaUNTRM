<?php

namespace App\Http\Livewire;

use App\Models\CargaHoraria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ShowCargaHorariaDocente extends Component
{
    use WithPagination;

    public $registros = 5;
    public $enumerator = 1;
    public $isHorarioReady = false;

    public function render()
    {
        $cargasLectiva = DB::table('carga_lectivas as cl')
            ->join('declaracion_juradas as dj', 'dj.id', '=', 'declaracionJurada_id')
            ->join('docentes as d', 'd.id', '=', 'dj.docente_id')
            ->join('periodos as p', 'p.id', '=', 'dj.periodo_id')
            ->select('cl.id as id', 'cl.estado_asignado', 'cl.estado_terminado', 'p.descripcion')
            ->where('docente_id', '=', Auth::user()->docente->id)
            ->paginate($this->registros);

        $cargaHoraria = CargaHoraria::all();

        return view('livewire.show-carga-horaria-docente', compact('cargasLectiva','cargaHoraria'));
    }

    public function updatingRegistros()
    {
        $this->resetPage();
    }
}
