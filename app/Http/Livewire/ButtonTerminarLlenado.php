<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ButtonTerminarLlenado extends Component
{
    public $cargaLectivaId;
    public $isOpenModalConfirm = false;

    public function mount($id)
    {
        $this->cargaLectivaId = $id;
    }

    public function render()
    {
        return view('livewire.button-terminar-llenado');
    }

    public function close()
    {
        $this->isOpenModalConfirm = false;
    }

    public function confirm()
    {
        
    }
}
