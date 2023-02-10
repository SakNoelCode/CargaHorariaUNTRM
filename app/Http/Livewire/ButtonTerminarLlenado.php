<?php

namespace App\Http\Livewire;

use App\Models\CargaHoraria;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ButtonTerminarLlenado extends Component
{
    public $cargaLectivaId;
    public $isOpenModalConfirm = false;

    //Variables para calculo de hora total
    public $arrayCargas, $arrayCursos;
    public $totalHorasCarga, $totalHorasCurso;
    public $isCompletoCarga, $isCompletoCurso;
    public $totalHoras;

    protected $listeners = ['UpdateParametrosCarga' => 'render', 'UpdateParametrosCurso' => 'render'];

    public function mount($id)
    {
        $this->cargaLectivaId = $id;
    }

    public function render()
    {
        $cargasAsignadas = DB::table('cargalectiva_carga as clc')
            ->select('clc.cantidad_horas as cantHoras')
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->get();

        $cursosAsignados = DB::table('cargalectiva_curso as clc')
            ->select(
                (DB::raw('clc.horas_teoria + clc.horas_practica as totalHoras')),
            )
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->orderBy('clc.id')
            ->get();

        $this->arrayCargas = $cargasAsignadas->toArray();
        $this->arrayCursos = $cursosAsignados->toArray();
        $this->calculateHorasAndStatus();
        $this->totalHoras = $this->totalHorasCarga + $this->totalHorasCurso;

        return view('livewire.button-terminar-llenado');
    }

    public function close()
    {
        $this->isOpenModalConfirm = false;
    }

    public function back()
    {
        return redirect()->route('cargasLectivasDocente');
    }

    public function confirm()
    {
        $cargaAsignada =  DB::table('carga_lectivas')
            ->where('id', '=', $this->cargaLectivaId)
            ->update([
                'estado_terminado' => 1
            ]);
        CargaHoraria::insert([
            'cargalectiva_id' => $this->cargaLectivaId,
            'estado_terminado' => 0
        ]);

        return redirect()->route('cargasLectivasDocente')->with('success','message');
    }

    public function calculateHorasAndStatus()
    {
        //Inicializar variables
        $this->isCompletoCarga = true;
        $this->isCompletoCurso = true;
        $this->totalHorasCarga = 0;
        $this->totalHorasCurso = 0;

        //Llenar variables de la carga
        foreach ($this->arrayCargas as $item) {
            $this->totalHorasCarga += $item->cantHoras;
            if ($item->cantHoras == 0) {
                $this->isCompletoCarga = false;
            }
        }

        //Llenar variables del curso
        foreach ($this->arrayCursos as $item) {
            $this->totalHorasCurso += $item->totalHoras;
            if ($item->totalHoras == 0) {
                $this->isCompletoCurso = false;
            }
        }
    }
}
