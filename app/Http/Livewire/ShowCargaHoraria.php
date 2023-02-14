<?php

namespace App\Http\Livewire;

use App\Models\Aula;
use App\Models\CargaHoraria;
use App\Models\Hora;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class ShowCargaHoraria extends Component
{
    public $cargaLectivaId, $cargaHorariaId;
    public $idCurso, $horasTeoriaCurso, $horasPracticaCurso;
    public $idAula, $dia, $horaInicio, $horaFinal;
    public $tipo;

    //Variables para comprobaciones
    public $havehorasTeoriaCurso = false, $havehorasPracticaCurso = false;
    public $horas;

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

        $this->horas = Hora::all();

        return view('livewire.show-carga-horaria', compact('cargaLectivaCurso', 'aulas'));
    }


    public function save()
    {
        $this->validate();

        DB::table('detalle_carga_horaria')->insert([
            'cargahoraria_id' => $this->cargaHorariaId,
            'cargalectiva_curso_id' => $this->idCurso,
            'aula_id' => $this->idAula,
            'dia' => $this->dia,
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
            ->select('clc.id', 'clc.horas_teoria', 'clc.horas_practica')
            ->where('clc.id', '=', $selectOption)
            ->first();

        $horasCursoCumplidas = DB::table('detalle_carga_horaria as dch')
            ->join('cargalectiva_curso as clc', 'clc.id', '=', 'dch.cargalectiva_curso_id')
            ->select('clc.id', 'dch.tipo')
            ->where('dch.cargalectiva_curso_id', $this->idCurso)
            ->where('dch.tipo',$this->tipo)
            ->get();

        //dd($horasCursoCumplidas);
        if ($horasCursoCumplidas->count()) {
            foreach ($horasCursoCumplidas as $item) {
               // dd($item);
                if ($item->tipo == 'teorico') {
                    $this->havehorasTeoriaCurso = true;
                }

                if ($item->tipo == 'practico') {
                    $this->havehorasPracticaCurso = true;
                }
            }
        }else{
            $this->havehorasTeoriaCurso = false;
            $this->havehorasPracticaCurso = false;
        }
        //dd($this->havehorasPracticaCurso);
        //$horasFinal = $horasCurso->except($horasCursoCumplidas);
        $this->horasTeoriaCurso = $horasCurso->horas_teoria;
        $this->horasPracticaCurso = $horasCurso->horas_practica;
    }

    public function comprobarHoras()
    {
        $horas = Hora::all();

        $horasOcupadas = DB::table('detalle_carga_horaria as dch')
            ->join('horas as h', 'h.id', 'dch.hora_inicio_id')
            ->select('h.id', 'dch.cargahoraria_id', 'dch.hora_inicio_id', 'dch.hora_fin_id')
            ->where('cargahoraria_id', $this->cargaHorariaId)
            ->where('dch.dia', $this->dia)
            ->get();

        $values = [];
        if ($horasOcupadas->count()) {
            foreach ($horasOcupadas as $item) {
                array_push($values, $this->getValuesBetween($item->hora_inicio_id, $item->hora_fin_id));
            }

            //Conversion de array bidimensional a unidimensional
            $string = json_encode($values);
            $array = json_decode($string, true);
            $result = [];
            foreach ($array as $sub_array) {
                foreach ($sub_array as $value) {
                    array_push($result, $value);
                }
            }
           // $this->horas = $horas->except($result);
           ////Aqui nos hemos quedado
        }
    }

    public function getValuesBetween($start, $end)
    {
        $values = [];
        for ($i = $start; $i <= $end; $i++) {
            array_push($values, $i);
        }
        return $values;
    }

    public function updatedIdCurso()
    {
        if ($this->idCurso != '') {
            $this->emit('showTipoCurso');

            //resetear valores cuando cambia de opcion
            $this->tipo = '';
            $this->idAula = '';
            $this->dia = '';
            $this->horaInicio = '';
            $this->horaFinal = '';
        } else {
            //resetear valores cuando selecciona la opcion vacia
            $this->idAula = '';
            $this->dia = '';
            $this->horaInicio = '';
            $this->horaFinal = '';
        }
    }

    public function updatedTipo()
    {
        if ($this->tipo != '') {
            $this->llenarHorasCurso($this->idCurso);
            $this->emit('showTipoCurso');
            $this->emit('showMensaje');

            if (!$this->havehorasPracticaCurso || !$this->havehorasTeoriaCurso) {
                $this->emit('activateAula');
            }

            $this->idAula = '';
            $this->dia = '';
            $this->horaInicio = '';
            $this->horaFinal = '';
        } else {
            $this->emit('showTipoCurso');

            $this->idAula = '';
            $this->dia = '';
            $this->horaInicio = '';
            $this->horaFinal = '';
        }
    }

    public function updatedIdAula()
    {
        $this->emit('showTipoCurso');
        $this->emit('showMensaje');
        $this->emit('activateAula');

        if ($this->idAula != '') {
            $this->emit('activateDia');
            $this->dia = '';
            $this->horaInicio = '';
            $this->horaFinal = '';
        } else {
            $this->dia = '';
            $this->horaInicio = '';
            $this->horaFinal = '';
        }
    }

    public function updatedDia()
    {
        $this->emit('showTipoCurso');
        $this->emit('showMensaje');
        $this->emit('activateAula');
        $this->emit('activateDia');

        if ($this->dia != '') {
            $this->comprobarHoras();
            $this->emit('activateHoraInicio');
            $this->horaInicio = '';
            $this->horaFinal = '';
        } else {
            $this->horaInicio = '';
            $this->horaFinal = '';
        }
    }

    public function updatedHoraInicio()
    {
        $this->emit('showTipoCurso');
        $this->emit('showMensaje');
        $this->emit('activateAula');
        $this->emit('activateDia');
        $this->emit('activateHoraInicio');

        if ($this->horaInicio != '') {
            $this->calculateHoraFinal();
        } else {
            $this->horaFinal = '';
        }
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
