<?php

namespace App\Http\Livewire;

use App\Models\Curso;
use Livewire\Component;

class AsignarCurso extends Component
{
    //Variables
    public $isOpen = false;
    public $curso,$ciclo;

    public function render()
    {
        $cursos = Curso::all();
        return view('livewire.asignar-curso',compact('cursos'));
    }
}
