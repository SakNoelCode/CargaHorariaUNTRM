<?php

namespace App\Http\Livewire;

use App\Models\Aula;
use App\Models\CargaHoraria;
use App\Models\Hora;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowAsignarHorarioCurso extends Component
{
    public $cargaLectivaIdCurso, $cargaHorariaIdCurso;
    public $idCurso, $horasTeoriaCurso, $horasPracticaCurso;
    public $idAulaCurso, $diaCurso, $horaInicioCurso, $horaFinalCurso;
    public $tipoCurso;

    //Variables para comprobaciones
    public $faltaCompletarHora = false;
    public $arrayHorasCurso;

    public function mount($id)
    {
        $cargaHoraria = CargaHoraria::where('cargalectiva_id', '=', $id)
            ->first();

        $this->cargaLectivaIdCurso = $id;
        $this->cargaHorariaIdCurso = $cargaHoraria->id;
    }

    public function render()
    {
        $cargaLectivaCurso = DB::table('cargalectiva_curso as clc')
            ->join('cursos as c', 'c.id', '=', 'clc.curso_id')
            ->select('clc.id', 'c.nombre')
            ->where('cargalectiva_id', '=', $this->cargaLectivaIdCurso)
            ->get();

        $aulasCurso = Aula::all();
        $horasCurso = Hora::all();

        return view('livewire.show-asignar-horario-curso', compact('cargaLectivaCurso', 'aulasCurso', 'horasCurso'));
    }

    public function save()
    {
        $validatedData = $this->validate([
            'idCurso' => 'required',
            'idAulaCurso' => 'required',
            'diaCurso' => 'required',
            'horaInicioCurso' => 'required',
            'horaFinalCurso' => 'required'
        ]);

        DB::table('detalle_carga_horaria')->insert([
            'cargahoraria_id' => $this->cargaHorariaIdCurso,
            'cargalectiva_curso_id' => $this->idCurso,
            'aula_id' => $this->idAulaCurso,
            'dia' => $this->diaCurso,
            'tipo' => $this->tipoCurso,
            'hora_inicio_id' => $this->horaInicioCurso,
            'hora_fin_id' => $this->horaFinalCurso
        ]);

        $this->resetForm();
        $this->emitTo('show-carga-horaria','render-table');
        $this->emit('alertMixin', 'success', 'Operación exitosa');
    }

    public function updatedIdCurso()
    {
        $this->tipoCurso = '';
        $this->idAulaCurso = '';
        $this->diaCurso = '';
        $this->horaInicioCurso = '';
        $this->horaFinalCurso = '';

        if ($this->idCurso != '') {
            $this->emit('showTipoCurso');
        }
    }

    public function updatedTipoCurso()
    {
        $this->idAulaCurso = '';
        $this->diaCurso = '';
        $this->horaInicioCurso = '';
        $this->horaFinalCurso = '';
        $this->emit('showTipoCurso');

        if ($this->tipoCurso != '') {
            $this->calcularHorasCurso();
            $this->emit('showMensajeCurso');

            if ($this->faltaCompletarHora) {
                $this->emit('activateAulaCurso');
            }
        }
    }

    public function updatedIdAulaCurso()
    {
        $this->diaCurso = '';
        $this->horaInicioCurso = '';
        $this->horaFinalCurso = '';
        $this->emit('showTipoCurso');
        $this->emit('showMensajeCurso');
        $this->emit('activateAulaCurso');

        if ($this->idAulaCurso != '') {
            $this->emit('activateDiaCurso');
        }
    }

    public function updatedDiaCurso()
    {
        $this->horaInicioCurso = '';
        $this->horaFinalCurso = '';
        $this->emit('showTipoCurso');
        $this->emit('showMensajeCurso');
        $this->emit('activateAulaCurso');
        $this->emit('activateDiaCurso');

        if ($this->diaCurso != '') {
            $this->comprobarHora();
            $this->emit('activateHoraInicioCurso');
        } else {
            $this->arrayHorasCurso = '';
        }
    }

    public function updatedHoraInicioCurso()
    {
        $this->emit('showTipoCurso');
        $this->emit('showMensajeCurso');
        $this->emit('activateAulaCurso');
        $this->emit('activateDiaCurso');
        $this->comprobarHora();
        $this->emit('activateHoraInicioCurso');

        if ($this->horaInicioCurso != '') {
            $this->calcularHoraFinal();
        } else {
            $this->horaFinalCurso = '';
        }
    }

    public function calcularHorasCurso()
    {
        $horasCurso = DB::table('cargalectiva_curso as clc')
            ->select('clc.id', 'clc.horas_teoria', 'clc.horas_practica')
            ->where('clc.id', '=', $this->idCurso)
            ->first();

        $horasCursoCumplidas = DB::table('detalle_carga_horaria as dch')
            ->join('cargalectiva_curso as clc', 'clc.id', '=', 'dch.cargalectiva_curso_id')
            ->select('clc.id', 'dch.tipo')
            ->where('dch.cargalectiva_curso_id', $this->idCurso)
            ->where('dch.tipo', $this->tipoCurso)
            ->get();

        if ($horasCursoCumplidas->count()) {
            $this->faltaCompletarHora = false;

            foreach ($horasCursoCumplidas as $item) {
                if ($item->tipo == 'teorico') {
                    $this->horasTeoriaCurso = 0;
                }
                if ($item->tipo == 'practico') {
                    $this->horasPracticaCurso = 0;
                }
            }
        } else {
            $this->horasTeoriaCurso = $horasCurso->horas_teoria;
            $this->horasPracticaCurso = $horasCurso->horas_practica;
            $this->faltaCompletarHora = true;
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

    public function comprobarHora()
    {
        $horasOcupadas = DB::table('detalle_carga_horaria as dch')
            ->join('horas as h', 'h.id', 'dch.hora_inicio_id')
            ->select('h.id', 'dch.cargahoraria_id', 'dch.hora_inicio_id', 'dch.hora_fin_id')
            ->where('cargahoraria_id', $this->cargaHorariaIdCurso)
            ->where('dch.dia', $this->diaCurso)
            ->get();

        if ($horasOcupadas->count()) {

            $values = [];
            $result = [];

            foreach ($horasOcupadas as $item) {
                array_push($values, $this->getValuesBetween($item->hora_inicio_id, $item->hora_fin_id));
            }

            //Conversion de array bidimensional a unidimensional
            $string = json_encode($values);
            $array = json_decode($string, true);

            foreach ($array as $sub_array) {
                foreach ($sub_array as $value) {
                    array_push($result, $value);
                }
            }

            //__Obtener el valor de las horas seleccionadas
            $horas_curso = 0;
            if ($this->tipoCurso == 'teorico') {
                $horas_curso = $this->horasTeoriaCurso;
            } elseif ($this->tipoCurso == 'practico') {
                $horas_curso = $this->horasPracticaCurso;
            }

            //__Obtener un vector de todas los Id de las horas
            $vector = Hora::all()->pluck('id')->toArray();
            //__Obtener un vector de de las horas que no están ocupadas
            $vector_horas_libres = array_diff($vector, $result);
            //__Este vector lo ocuparemos para llenar las horas que no deben incluirse
            $vector_resultante = [];

            //__recorro el array de horas libres
            foreach ($vector_horas_libres as $item) {
                //__Calculo la suma de horas que necesita el curso
                $element = $item + ($horas_curso - 1);
                //__calculo el rango de valores que estan entre estos numeros ($item y $element)
                $rango = $this->getValuesBetween($item, $element);

                //__recorro este rango
                foreach ($rango as $r) {
                    //__Compruebo si el elemento no existe en el array de horas libres 
                    if (!in_array($r, $vector_horas_libres)) {
                        //__Guardo en otro array el elemento que no debe incluirse
                        $vector_resultante[] = $item;
                        //__Con el break termino la ejecución del bucle foreach
                        break;
                    }
                }
            }
            //__Verificaciones finales
            $horas = Hora::all();
            //__Exceptuar tanto las horas ocupadas, como las horas que no pueden ser ocupadas por comprobación
            $value = $horas->except($result);
            $valueFinal = $value->except($vector_resultante);

            $this->arrayHorasCurso = collect($valueFinal);
        } else {

            //__Obtener un vector de todas los Id de las horas
            $vector_horas_libres = Hora::all()->pluck('id')->toArray();

            //__Obtener el valor de las horas seleccionadas
            $horas_curso = 0;
            if ($this->tipoCurso == 'teorico') {
                $horas_curso = $this->horasTeoriaCurso;
            } elseif ($this->tipoCurso == 'practico') {
                $horas_curso = $this->horasPracticaCurso;
            }

            //__Este vector lo ocuparemos para llenar las horas que no deben incluirse
            $vector_resultante = [];

            //__recorro el array de horas libres
            foreach ($vector_horas_libres as $item) {
                //__Calculo la suma de horas que necesita el curso
                $element = $item + ($horas_curso - 1);
                //__calculo el rango de valores que estan entre estos numeros ($item y $element)
                $rango = $this->getValuesBetween($item, $element);

                //__recorro este rango
                foreach ($rango as $r) {
                    //__Compruebo si el elemento no existe en el array de horas libres 
                    if (!in_array($r, $vector_horas_libres)) {
                        //__Elimino el elemento $item del array de horas libres   //array_splice($vector_horas_libres, $item, 1);
                        //__Guardo en otro array el elemento que no debe incluirse
                        $vector_resultante[] = $item;
                        //__Con el break termino la ejecución del bucle foreach
                        break;
                    }
                }
            }

            $this->arrayHorasCurso = collect(Hora::all()->except($vector_resultante));
        }
    }

    public function calcularHoraFinal()
    {
        if ($this->tipoCurso == 'teorico') {
            $this->horaFinalCurso = ($this->horaInicioCurso + $this->horasTeoriaCurso) - 1;
        }
        if ($this->tipoCurso == 'practico') {
            $this->horaFinalCurso = ($this->horaInicioCurso + $this->horasPracticaCurso) - 1;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'idCurso',
            'tipoCurso',
            'horasTeoriaCurso',
            'horasPracticaCurso',
            'idAulaCurso',
            'diaCurso',
            'horaInicioCurso',
            'horaFinalCurso',
            'arrayHorasCurso',
            'faltaCompletarHora'
        ]);

        $this->resetErrorBag();
        $this->resetValidation();
    }
}
