<?php

namespace App\Http\Livewire;

use App\Models\Aula;
use App\Models\CargaHoraria;
use App\Models\Hora;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\Livewire;

class ShowCargaHoraria extends Component
{
    public $cargaLectivaId, $cargaHorariaId;
    public $idCurso, $horasTeoriaCurso, $horasPracticaCurso;
    public $idAula, $dia, $horaInicio, $horaFinal;
    public $tipo;

    protected $listeners = [];

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
        $dias = collect([
            ['name' => 'Lunes', 'value' => 1],
            ['name' => 'Martes', 'value' => 2],
            ['name' => 'Miércoles', 'value' => 3],
            ['name' => 'Jueves', 'value' => 4],
            ['name' => 'Viernes', 'value' => 5],
        ]);

        return view('livewire.show-carga-horaria', compact('cargaLectivaCurso', 'aulas', 'horas', 'dias'));
    }


    public function save()
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

        DB::table('detalle_carga_horaria')->insert([
            'cargahoraria_id' => $this->cargaHorariaId,
            'cargalectiva_curso_id' => $this->idCurso,
            'aula_id' => $this->idAula,
            'dia' => $valorDia,
            'tipo' => $this->tipo,
            'hora_inicio_id' => $this->horaInicio,
            'hora_fin_id' => $this->horaFinal
        ]);

        $this->resetForm();
        $this->emit('alertMixin', 'success', 'Operación exitosa');
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

    public function updatedIdCurso()
    {
        if ($this->idCurso != '') {
            $this->emit('showTipoCurso');
        } else {
            $this->emit('hideTipoCurso');
        }
    }

    public function updatedTipo()
    {
        if ($this->tipo != '') {
            $this->llenarHorasCurso($this->idCurso);
            $this->emit('showTipoCurso');
            $this->emit('showMensaje');
        } else {
            $this->emit('showTipoCurso');
            $this->emit('hideMensaje');
        }
    }

    public function updatedIdAula()
    {
        $this->emit('showTipoCurso');
        $this->emit('showMensaje');
    }

    public function updatedDia()
    {
        $this->emit('showTipoCurso');
        $this->emit('showMensaje');
    }

    public function updatedHoraInicio()
    {
        $this->emit('showTipoCurso');
        $this->emit('showMensaje');
        $this->calculateHoraFinal();
    }

    public function updatedHoraFinal()
    {
        /* $this->emit('showTipoCurso');
        $this->emit('showMensaje');*/
    }

    public function calculateHoraFinal()
    {
        if ($this->horaInicio != '') {
            if ($this->tipo == 'teorico') {
                $horaFinal = $this->horaInicio + $this->horasTeoriaCurso;
                $this->horaFinal = $horaFinal - 1;
            }
            if ($this->tipo == 'practico') {
                $horaFinal = $this->horaInicio + $this->horasPracticaCurso;
                $this->horaFinal = $horaFinal - 1;
            }
        }
    }

    public function resetForm()
    {
        $this->reset([
            'idCurso',
            'tipo',
            'horasTeoriaCurso',
            'horasPracticaCurso',
            'idAula',
            'dia',
            'horaInicio',
            'horaFinal'
        ]);

        $this->resetErrorBag();
        $this->resetValidation();
    }
}
