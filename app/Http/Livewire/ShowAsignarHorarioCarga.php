<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Aula;
use App\Models\CargaHoraria;
use App\Models\Hora;
use Illuminate\Support\Facades\DB;

class ShowAsignarHorarioCarga extends Component
{
    public $cargaLectivaIdCarga, $cargaHorariaIdCarga;
    public $idCarga, $horasCarga, $horasCargaSeleccionadas;
    public $idAulaCarga, $diaCarga, $horaInicioCarga, $horaFinalCarga;

    //Variables para comprobaciones
    public $arrayHorasCarga, $haveHorasOcupadasCarga = false, $haveHorasLibresCarga = false;

    public function mount($id)
    {
        $cargaHoraria = CargaHoraria::where('cargalectiva_id', '=', $id)
            ->first();

        $this->cargaLectivaIdCarga = $id;
        $this->cargaHorariaIdCarga = $cargaHoraria->id;
    }

    public function render()
    {
        $cargaLectivaCarga = DB::table('cargalectiva_carga as clc')
            ->join('cargas as c', 'c.id', '=', 'clc.carga_id')
            ->select('clc.id', 'c.titulo')
            ->where('cargalectiva_id', '=', $this->cargaLectivaIdCarga)
            ->get();

        $aulas = Aula::all();
        $horas = Hora::all();

        return view('livewire.show-asignar-horario-carga', compact('cargaLectivaCarga', 'aulas', 'horas'));
    }

    public function save()
    {
        $validatedData = $this->validate([
            'idCarga' => 'required',
            'horasCargaSeleccionadas' => 'required|min:1|numeric',
            'idAulaCarga' => 'required',
            'diaCarga' => 'required',
            'horaInicioCarga' => 'required',
            'horaFinalCarga' => 'required'
        ]);

        DB::table('detalle_carga_horaria')->insert([
            'cargahoraria_id' => $this->cargaHorariaIdCarga,
            'cargalectiva_carga_id' => $this->idCarga,
            'aula_id' => $this->idAulaCarga,
            'dia' => $this->diaCarga,
            'tipo' => 'carga',
            'hora_inicio_id' => $this->horaInicioCarga,
            'hora_fin_id' => $this->horaFinalCarga
        ]);

        $this->resetFormCarga();
        $this->emit('alertMixin', 'success', 'Operación exitosa');
    }

    //Función que se ejecuta cada vez que haya un cambio en IdCarga
    public function updatedIdCarga()
    {
        $this->resetHaveHoras();
        $this->idAulaCarga = '';
        $this->diaCarga = '';
        $this->horaInicioCarga = '';
        $this->horaFinalCarga = '';

        if ($this->idCarga != '') {
            $this->emit('showMensajeCarga');
            $this->emit('showInputHorasSeleccionadas');
            $this->calcularHorasCarga();
            if ($this->horasCarga > 0) {
                $this->emit('activateAulaCarga');
            }
        }
    }

    public function updatedHorasCargaSeleccionadas()
    {
        if ($this->horasCarga > 0) {
            $this->emit('showMensajeCarga');
            $this->emit('showInputHorasSeleccionadas');
            $this->emit('activateAulaCarga');
            $this->resetHaveHoras();
            $this->idAulaCarga = '';
            $this->diaCarga = '';
            $this->horaInicioCarga = '';
            $this->horaFinalCarga = '';
        }
    }

    public function updatedIdAulaCarga()
    {
        $this->emit('showMensajeCarga');
        $this->emit('showInputHorasSeleccionadas');
        $this->emit('activateAulaCarga');
        $this->resetHaveHoras();
        $this->diaCarga = '';
        $this->horaInicioCarga = '';
        $this->horaFinalCarga = '';

        if ($this->idAulaCarga != '') {
            $this->emit('activateDiaCarga');
        }
    }

    public function updatedDiaCarga()
    {
        $this->emit('showMensajeCarga');
        $this->emit('showInputHorasSeleccionadas');
        $this->emit('activateAulaCarga');
        $this->emit('activateDiaCarga');
        $this->horaInicioCarga = '';
        $this->horaFinalCarga = '';

        if ($this->diaCarga != '') {
            $this->calcularHorasDisponibles();
            $this->emit('activateHoraInicioCarga');
        } else {
            $this->resetHaveHoras();
        }
    }

    public function updatedHoraInicioCarga()
    {
        $this->emit('showMensajeCarga');
        $this->emit('showInputHorasSeleccionadas');
        $this->emit('activateAulaCarga');
        $this->emit('activateDiaCarga');
        $this->emit('activateHoraInicioCarga');
        $this->calcularHorasDisponibles();

        if ($this->horaInicioCarga != '') {
            $this->calcularHoraFinalCarga();
        } else {
            $this->horaFinalCarga = '';
        }
    }

    public function calcularHorasCarga()
    {
        $horasCarga = DB::table('cargalectiva_carga as clc')
            ->select('clc.id', 'clc.cantidad_horas')
            ->where('clc.id', '=', $this->idCarga)
            ->first();

        $horasCargaCumplidas = DB::table('detalle_carga_horaria as dch')
            ->join('cargalectiva_carga as clc', 'clc.id', '=', 'dch.cargalectiva_carga_id')
            ->select('clc.id', 'dch.tipo', 'dch.hora_inicio_id', 'dch.hora_fin_id')
            ->where('dch.cargalectiva_carga_id', $this->idCarga)
            ->where('dch.tipo', 'carga')
            ->get();

        if ($horasCargaCumplidas->count()) {
            //Variables para manejar si tiene la carga tiene horas cumplidas
            $totalHorasCumplidas = 0;

            foreach ($horasCargaCumplidas as $item) {
                $totalHorasCumplidas += count($this->getValuesBetween($item->hora_inicio_id, $item->hora_fin_id));
            }

            $this->horasCarga = $horasCarga->cantidad_horas - $totalHorasCumplidas;
            $this->horasCargaSeleccionadas = $this->horasCarga;
        } else {
            //Si la carga no tiene horas cumplidas asignar directamente
            $this->horasCarga = $horasCarga->cantidad_horas;
            $this->horasCargaSeleccionadas = $this->horasCarga;
        }
    }

    public function calcularHorasDisponibles()
    {
        //Consulta para obtener las horas que están ocupadas
        $horasOcupadas = DB::table('detalle_carga_horaria as dch')
            ->join('horas as h', 'h.id', 'dch.hora_inicio_id')
            ->select('h.id', 'dch.cargahoraria_id', 'dch.hora_inicio_id', 'dch.hora_fin_id')
            ->where('cargahoraria_id', $this->cargaHorariaIdCarga)
            ->where('dch.dia', $this->diaCarga)
            ->get();

        if ($horasOcupadas->count()) {
            //---1 PROCESO: OBTENER LAS HORAS QUE YA ESTAN OCUPADAS
            $values = [];
            $result = [];
            //Obtener los valores de las horas entre rangos de horas
            foreach ($horasOcupadas as $item) {
                array_push($values, $this->getValuesBetween($item->hora_inicio_id, $item->hora_fin_id));
            }
            //LLenar el array $result con los valores obtenidos y convertidos en arreglo unidimiensional
            $string = json_encode($values);
            $array = json_decode($string, true);
            foreach ($array as $sub_array) {
                foreach ($sub_array as $value) {
                    array_push($result, $value);
                }
            }

            //---2 PROCESO: OBTENER LAS HORAS QUE NO PUEDEN SER SELECCIONADAS
            $vector_resultante = [];
            //Obtener un vector de todas los Id de las horas
            $vector = Hora::all()->pluck('id')->toArray();
            //Obtener el valor de las horas seleccionadas
            $horas_carga = $this->horasCargaSeleccionadas;
            //__Obtener un vector de de las horas que no están ocupadas
            $vector_horas_libres = array_diff($vector, $result);
            //__recorro el array de horas libres
            foreach ($vector_horas_libres as $item) {
                //__Calculo la suma de horas que necesita el curso
                $element = $item + ($horas_carga - 1);
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

            //---3 PROCESO: QUITAR AL ARREGLO ORIGINAL DE HORAS AMBAS RESTRICCIONES
            $horas = Hora::all();
            $value = $horas->except($result);
            $valueFinal = $value->except($vector_resultante);

            //---4 PROCESO: ASIGNACION DE VARIABLES
            $this->arrayHorasCarga = collect($valueFinal);
            $this->haveHorasOcupadasCarga = true;
            $this->haveHorasLibresCarga = false;
        } else {
            //---1 PROCESO: OBTENER LAS HORAS QUE NO PUEDEN SER SELECCIONADAS
            $vector_resultante = [];
            //__Obtener un vector de de las horas que no están ocupadas
            $vector_horas_libres = Hora::all()->pluck('id')->toArray();
            //Obtener el valor de las horas seleccionadas
            $horas_carga = $this->horasCargaSeleccionadas;
            //__recorro el array de horas libres
            foreach ($vector_horas_libres as $item) {
                //__Calculo la suma de horas que necesita el curso
                $element = $item + ($horas_carga - 1);
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

            //---2 PROCESO: ASIGNACION DE VARIABLES
            $this->arrayHorasCarga = collect(Hora::all()->except($vector_resultante));
            $this->haveHorasOcupadasCarga = false;
            $this->haveHorasLibresCarga = true;
        }
    }

    public function calcularHoraFinalCarga()
    {
        $this->horaFinalCarga = $this->horaInicioCarga + ($this->horasCargaSeleccionadas - 1);
    }

    public function getValuesBetween($start, $end)
    {
        $values = [];
        for ($i = $start; $i <= $end; $i++) {
            array_push($values, $i);
        }
        return $values;
    }

    public function resetHaveHoras()
    {
        $this->reset([
            'haveHorasOcupadasCarga',
            'haveHorasLibresCarga'
        ]);
    }

    public function resetFormCarga()
    {
        $this->reset([
            'idCarga',
            'horasCarga',
            'horasCargaSeleccionadas',
            'idAulaCarga',
            'diaCarga',
            'horaInicioCarga',
            'horaFinalCarga',
            'arrayHorasCarga',
            'haveHorasOcupadasCarga',
            'haveHorasLibresCarga'
        ]);
    }
}
