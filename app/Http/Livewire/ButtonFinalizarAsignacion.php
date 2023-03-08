<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ButtonFinalizarAsignacion extends Component
{
    public $cargaLectivaId;
    public $isOpenModalConfirm = false;

    public function mount($id)
    {
        $this->cargaLectivaId = $id;
    }

    public function render()
    {
        return view('livewire.button-finalizar-asignacion');
    }

    public function confirm()
    {
        $Cursos = DB::table('cargalectiva_curso')
            ->where('cargalectiva_id', $this->cargaLectivaId)
            ->get();

        $Cargas = DB::table('cargalectiva_carga')
            ->where('cargalectiva_id', $this->cargaLectivaId)
            ->get();

        if ($Cargas->count() > 0 && $Cursos->count() > 0) {
            $cargaAsignada =  DB::table('carga_lectivas')
                ->where('id', '=', $this->cargaLectivaId)
                ->update([
                    'estado_asignado' => 1
                ]);

            $this->isOpenModalConfirm = false;
            //$this->emit('alertBox', 'Operación exitosa', 'Asignación finalizada', 'success');
            return redirect()->route('cargasLectivasJefeDepartamento')->with('success', 'exito');
        } else {
            $this->isOpenModalConfirm = false;
            $this->emit('alertMixin', 'error', 'Debe por lo menos asignar una carga y un curso');
        }
    }

    public function close()
    {
        $this->isOpenModalConfirm = false;
    }
}
