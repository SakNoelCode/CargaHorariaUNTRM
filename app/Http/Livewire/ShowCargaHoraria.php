<?php

namespace App\Http\Livewire;

use App\Models\Aula;
use App\Models\CargaHoraria;
use App\Models\Hora;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowCargaHoraria extends Component
{
    public $cargaLectivaId, $cargaHorariaId;
    public $idCurso, $horasTeoriaCurso, $horasPracticaCurso;
    public $idAula, $dia, $horaInicio, $horaFinal;
    public $tipo, $isTeorico, $isPractico;

    protected $listeners =
    [
        'CursoSeleccionado' => 'llenarHorasCurso',
        'refreshAula',
        'refreshHoraInicio',
        'tipoHora'
    ];

    protected $rules = [
        'idCurso' => 'required',
        'idAula' => 'required',
        'dia' => 'required',
        'horaInicio' => 'required',
        'horaFinal' => 'required'
    ];

    public function mount($id)
    {
        $cargaHoraria = CargaHoraria::where('cargalectiva_id', '=', $id)
            ->first();

        $this->cargaLectivaId = $id;
        $this->cargaHorariaId = $cargaHoraria->id;
    }

    public function render()
    {
        $cargaLectivaCurso = DB::table('cargalectiva_curso as clc')
            ->join('cursos as c', 'c.id', '=', 'clc.curso_id')
            ->select('clc.id', 'c.nombre')
            ->where('cargalectiva_id', '=', $this->cargaLectivaId)
            ->get();

        $aulas = Aula::all();
        $horas = Hora::all();

        return view('livewire.show-carga-horaria', compact('cargaLectivaCurso', 'aulas', 'horas'));
    }

    public function updateCurso()
    {
        $this->validate();

        $valorDia = '';
        switch ($this->dia) {
            case 1:
                $valorDia = 'Lunes';
                break;
            case 2:
                $valorDia = 'Martes';
                break;
            case 3:
                $valorDia = 'Miércoles';
                break;
            case 4:
                $valorDia = 'Jueves';
                break;
            case 5:
                $valorDia = 'Viernes';
                break;
        }

        //dd('Hola');

        /*
        DB::table('detalle_carga_horaria')->insert([
            'cargahoraria_id' => $this->cargaHorariaId,
            'cargalectiva_carga_id' => 0,
            'cargalectiva_curso_id' => $this->idCurso,
            'aula_id' => $this->idAula,
            'dia' => $valorDia,
            'tipo' => $this->tipo,
            'hora_inicio_id' => $this->horaInicio,
            'hora_fin_id' => $this->horaFinal
        ]);*/
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

    public function refreshAula()
    {
        $this->reset([
            'idAula'
        ]);
    }

    public function refreshHoraInicio()
    {
        $this->reset([
            'horaInicio'
        ]);
    }

    public function tipoHora($value)
    {
        $this->tipo = $value;
    }
}
