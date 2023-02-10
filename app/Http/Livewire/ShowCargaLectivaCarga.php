<?php

namespace App\Http\Livewire;

use App\Models\CargaLectiva;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowCargaLectivaCarga extends Component
{
    public $cargaLectivaId, $estadoCargaLectiva;
    public $enumerator = 1;
    public $isOpenModalDelete = false;
    public $isOpenModalEdit = false;
    public $deleteId;
    public $isDocente;

    //Variables para editar la carga
    public $idCarga;
    public $descripcion, $cantHoras;

    //Variables para calcular las horas totales}
    public $isCompletoCargas;
    public $totalHorasArray;
    public $totalHoras;

    protected $rules = [
        'descripcion' => 'required',
        'cantHoras' => 'required|numeric'
    ];

    protected $listeners = ['render_table_carga_lectiva_carga' => 'render'];

    public function mount($id, $isDocente)
    {
        $this->cargaLectivaId = $id;
        $this->estadoCargaLectiva = CargaLectiva::find($id)->estado_asignado;
        $this->isDocente = $isDocente;
    }

    public function render()
    {
        $cargasAsignadas = DB::table('cargalectiva_carga as clc')
            ->join('cargas as c', 'c.id', '=', 'clc.carga_id')
            ->select('clc.id as id', 'c.titulo as tituloCarga', 'clc.descripcion as descripcion', 'clc.cantidad_horas as cantHoras')
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->get();

        //Calculo del total de horas
        $this->isCompletoCargas = true;
        $this->totalHoras = 0;
        $this->totalHorasArray = $cargasAsignadas->toArray();
        foreach ($this->totalHorasArray as $item) {
            $this->totalHoras +=  $item->cantHoras;
            if($item->cantHoras == 0){
                $this->isCompletoCargas = false;
            }
        }

        return view('livewire.show-carga-lectiva-carga', compact('cargasAsignadas'));
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
        $this->isOpenModalDelete = true;
    }

    public function delete()
    {
        $cargaAsignada =  DB::table('cargalectiva_carga')
            ->where('id', '=', $this->deleteId)
            ->delete();
        $this->isOpenModalDelete = false;
        $this->emit('alertMixin', 'success', 'Carga eliminada exitosamente');
    }

    public function close()
    {
        $this->isOpenModalDelete = false;
    }

    public function edit($id)
    {
        $this->resetFormEdit();
        $this->resetFormEditValidation();
        $this->idCarga = $id;

        $cargaLectiva_carga = DB::table('cargalectiva_carga')
            ->where('id', $id)
            ->first();

        if ($cargaLectiva_carga->descripcion != null) {
            $this->descripcion = $cargaLectiva_carga->descripcion;
        }
        if ($cargaLectiva_carga->cantidad_horas != 0) {
            $this->cantHoras = $cargaLectiva_carga->cantidad_horas;
        }

        $this->isOpenModalEdit = true;
    }

    public function update()
    {
        $this->validate();

        $carga = DB::table('cargalectiva_carga')
            ->where('id', $this->idCarga)
            ->update([
                'descripcion' => $this->descripcion,
                'cantidad_horas' => $this->cantHoras
            ]);

        $this->closeFormEdit();
        $this->emit('alertMixin', 'success', 'Carga completada exitosamente');
    }

    public function closeFormEdit()
    {
        $this->isOpenModalEdit = false;
    }

    public function resetFormEdit()
    {
        $this->reset([
            'descripcion',
            'cantHoras'
        ]);
    }

    public function resetFormEditValidation()
    {
        //Borrar avisos de validación
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
