<?php

namespace App\Http\Livewire;

use App\Models\Aula;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowCargaHoraria extends Component
{
    public $cargaLectivaId;
    public $idCurso, $nameCurso, $horasTeoriaCurso, $horasPracticaCurso;
    public $idAula, $dia, $horaInicio, $horaFinal;

    protected $listeners = ['CursoSeleccionado' => 'llenarHorasCurso'];

    public function mount($id)
    {
        $this->cargaLectivaId = $id;
    }

    public function render()
    {
        $cargaLectivaCurso = DB::table('cargalectiva_curso as clc')
            ->join('cursos as c', 'c.id', '=', 'clc.curso_id')
            ->select('clc.id', 'c.nombre')
            ->where('cargalectiva_id', '=', $this->cargaLectivaId)
            ->get();

        $aulas = Aula::all();

        return view('livewire.show-carga-horaria', compact('cargaLectivaCurso','aulas'));
    }

    public function updateCurso()
    {
    }

    public function llenarHorasCurso($selectOption)
    {
        $horasCurso = DB::table('cargalectiva_curso as clc')
            ->select('clc.horas_teoria', 'clc.horas_practica')
            ->where('clc.id', '=', $selectOption)
            ->first();
        $this->horasTeoriaCurso = $horasCurso->horas_teoria;
        $this->horasPracticaCurso = $horasCurso->horas_practica;
    }
}
