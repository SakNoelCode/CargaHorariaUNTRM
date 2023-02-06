<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowCargaLectivaCarga extends Component
{
    public $cargaLectivaId;
    public $enumerator = 1;
    public $isOpenModalDelete = false;
    public $deleteId;

    protected $listeners = ['render_table_carga_lectiva_carga' => 'render'];

    public function mount($id)
    {
        $this->cargaLectivaId = $id;
    }

    public function render()
    {
        $cargasAsignadas = DB::table('cargalectiva_carga as clc')
            ->join('cargas as c', 'c.id', '=', 'clc.carga_id')
            ->select('clc.id as id', 'c.titulo as tituloCarga')
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->get();

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
}
