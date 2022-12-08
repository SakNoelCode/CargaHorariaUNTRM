<?php

namespace App\Http\Livewire;

use App\Models\DeclaracionJurada;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDeclaracionJuradaJefe extends Component
{
    use WithPagination;
    //Variables
    public $numeracion = 1, $numberOfRecords = "5";
    public $showModalEdit = false;

    //Variables del la declaracion jurada
    public $nameDocente,$periodo,$observaciones,$estado;

    public function render()
    {
        $declaraciones = DeclaracionJurada::orderBy('id', 'desc')
            ->where('estado_enviado', 1)
            ->paginate($this->numberOfRecords);

        return view('livewire.show-declaracion-jurada-jefe', compact('declaraciones'));
    }

    //descargar documento
    public function download(DeclaracionJurada $declaracion)
    {
        $declaracion = $declaracion;
        $file_path = public_path('storage/documents/' . $declaracion->documento);
        return response()->download($file_path);
    }

    public function edit(DeclaracionJurada $declaracion){
        //$declaracion = $declaracion;

        //dd($declaracion);

        $this->nameDocente = $declaracion->docente->user->name;
        $this->periodo = $declaracion->periodo->descripcion;

        $this->showModalEdit = true;

    }
}
