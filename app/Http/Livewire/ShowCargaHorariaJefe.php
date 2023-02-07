<?php

namespace App\Http\Livewire;

use App\Models\CargaLectiva;
use Livewire\Component;
use Livewire\WithPagination;

class ShowCargaHorariaJefe extends Component
{
    //Importaciones
    use WithPagination;

    //Variables
    public $registros = "5";

    public function render()
    {
        $cargas = CargaLectiva::orderBy('id', 'desc')
            ->paginate($this->registros);

        return view('livewire.show-carga-horaria-jefe', compact('cargas'));
    }

    //Para evitar el bug de no existencia de cargas horarias
    public function updatingRegistros()
    {
        $this->resetPage();
    }
}
