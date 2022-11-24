<?php

namespace App\Http\Livewire;

use App\Models\DeclaracionJurada;
use App\Models\Periodo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateDeclaracionJurada extends Component
{
    public $isOpen = false;
    public $nameDocente, $periodo_id = '',$idDocente;

    protected $rules = [
        'periodo_id' => 'required'
    ];

    public function mount()
    {
        $this->nameDocente = Auth::user()->name;
        $this->idDocente = Auth::user()->docente->id;
    }

    public function render()
    {
        $periodos = Periodo::all();
        return view('livewire.create-declaracion-jurada', compact('periodos'));
    }

    public function save()
    {
        $this->validate();
        
        //Crear Declaracion
        $declaracion = new DeclaracionJurada();
        $declaracion->estado = 'generado';
        $declaracion->estado_enviado = 0;
        $declaracion->periodo_id = $this->periodo_id;
        $declaracion->docente_id = $this->idDocente;
        $declaracion->save();

        //renderizar tabla
        $this->emitTo('show-declaracion-jurada','render');

        //mostrar alerta
        $this->emit('alertBox','Generacion éxitosa','Descarga el documento generado para que lo firmes','success');

        //resetear valores
        $this->cleanFields();
    }

    public function cleanFields()
    {
        $this->reset([
            'isOpen',
            'periodo_id'
        ]);
    }
}
