<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AsignarCarga extends Component
{
    //Variables
    public $isOpen = false;

    public function render()
    {
        return view('livewire.asignar-carga');
    }
}
