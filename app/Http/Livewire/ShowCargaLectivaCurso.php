<?php

namespace App\Http\Livewire;

use App\Models\CargaLectiva;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowCargaLectivaCurso extends Component
{

    public $cargaLectivaId, $estadoCargaLectiva;
    public $isOpenModalDelete = false;
    public $isOpenModalEdit = false;
    public $deleteId;
    public $isDocente;

    //Variables para editar curso
    public $idCurso;
    public $numAlumnos, $horasTeoria, $horasPractica;

    //Variables para calcular las horas totales
    public $totalHorasArray;
    public $totalHoras = 0;

    protected $rules = [
        'numAlumnos' => 'required|numeric',
        'horasTeoria' => 'required|numeric',
        'horasPractica' => 'required|numeric'

    ];

    protected $listeners = ['render_table_carga_lectiva_curso' => 'render'];

    public function mount($id, $isDocente)
    {
        $this->cargaLectivaId = $id;
        $this->estadoCargaLectiva = CargaLectiva::find($id)->estado_asignado;
        $this->isDocente = $isDocente;
    }

    public function render()
    {
        $cursosAsignados = DB::table('cargalectiva_curso as clc')
            ->join('cursos as c', 'c.id', '=', 'clc.curso_id')
            ->join('ciclos as ci', 'ci.id', '=', 'clc.ciclo_id')
            ->join('seccions as s', 's.id', '=', 'clc.seccion_id')
            ->select(
                (DB::raw('clc.horas_teoria + clc.horas_practica as totalHoras')),
                'clc.id as id',
                'c.nombre as nombreCurso',
                'ci.descripcion as descripcionCiclo',
                's.descripcion as descripcionSeccion',
                'clc.numero_alumnos as numAlumnos',
                'clc.horas_teoria as horasTeoria',
                'clc.horas_practica as horasPractica'
            )
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->orderBy('clc.id')
            ->get();

        $this->totalHorasArray = $cursosAsignados->toArray();

        foreach ($this->totalHorasArray as $item) {
            $this->totalHoras +=  $item->totalHoras;
        }
        //dd($this->totalHoras);

        /*foreach ($cursosAsignados as $item) {
            dd($item->nombre);
        }*/

        return view('livewire.show-carga-lectiva-curso', ['cursosAsignados' => $cursosAsignados]);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
        $this->isOpenModalDelete = true;
    }

    public function delete()
    {
        $cursoAsignado =  DB::table('cargalectiva_curso')
            ->where('id', '=', $this->deleteId)
            ->delete();
        $this->isOpenModalDelete = false;
        $this->emit('alertMixin', 'success', 'Curso eliminado exitosamente');
    }

    public function edit($id)
    {
        $this->resetFormEdit();
        $this->resetFormEditValidation();
        $this->idCurso = $id;

        //Hacer consulta si existen registros
        $cargaLectiva_curso = DB::table('cargalectiva_curso')
            ->where('id', $id)
            ->first();

        if ($cargaLectiva_curso->numero_alumnos != 0) {
            $this->numAlumnos = $cargaLectiva_curso->numero_alumnos;
        }
        if ($cargaLectiva_curso->horas_teoria != 0) {
            $this->horasTeoria = $cargaLectiva_curso->horas_teoria;
        }
        if ($cargaLectiva_curso->horas_practica != 0) {
            $this->horasPractica = $cargaLectiva_curso->horas_practica;
        }

        $this->isOpenModalEdit = true;
    }

    public function close()
    {
        $this->isOpenModalEdit = false;
    }

    public function update()
    {
        $this->validate();

        $curso = DB::table('cargalectiva_curso')
            ->where('id', $this->idCurso)
            ->update([
                'numero_alumnos' => $this->numAlumnos,
                'horas_teoria' => $this->horasTeoria,
                'horas_practica' => $this->horasPractica
            ]);

        $this->close();
        $this->emit('alertMixin', 'success', 'Curso completado exitosamente');
    }

    public function resetFormEdit()
    {
        $this->reset([
            'numAlumnos',
            'horasTeoria',
            'horasPractica'
        ]);
    }

    public function resetFormEditValidation()
    {
        //Borrar avisos de validación
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
