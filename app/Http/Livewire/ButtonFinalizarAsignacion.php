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
        $cargaAsignada =  DB::table('carga_lectivas')
            ->where('id', '=', $this->cargaLectivaId)
            ->update([
                'estado_asignado' => 1
            ]);

        $this->isOpenModalConfirm = false;
        //$this->emit('alertBox', 'Operación exitosa', 'Asignación finalizada', 'success');
        return redirect()->route('cargasLectivasJefeDepartamento')->with('success','exito');
    }

    public function close()
    {
        $this->isOpenModalConfirm = false;
    }
}
