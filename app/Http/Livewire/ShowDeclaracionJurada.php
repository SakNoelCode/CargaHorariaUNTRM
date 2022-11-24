<?php

namespace App\Http\Livewire;

use App\Models\DeclaracionJurada;
use Livewire\Component;

class ShowDeclaracionJurada extends Component
{
    protected $listeners = [
        'render'
    ];

    public $numeracion = 1;

    public function render()
    {
        $declaraciones = DeclaracionJurada::all();
        return view('livewire.show-declaracion-jurada', ['declaraciones' => $declaraciones]);
    }
}
