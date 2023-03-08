<?php

namespace App\Http\Livewire;

use App\Models\Carga;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AsignarCarga extends Component
{
    //Variables
    public $isOpen = false;
    public $cargasSelected = [];
    public $cargaLectivaId;
    public $enumerator = 1;

    protected $rules = [
        'cargasSelected' => 'required'
    ];

    protected $messages = [
        'cargasSelected.required' => 'Debe seleccionar al menos una carga'
    ];

    protected $validationAttributes = [
        'cargasSelected' => 'cargas'
    ];

    public function mount($id)
    {
        $this->cargaLectivaId = $id;
    }

    public function render()
    {
        $cargasAsignadas = DB::table('carga_lectivas as cl')
            ->join('cargalectiva_carga as clc', 'cl.id', '=', 'clc.cargalectiva_id')
            ->where('clc.cargalectiva_id', '=', $this->cargaLectivaId)
            ->pluck('carga_id')->toArray();

        $cargas = Carga::all()->except($cargasAsignadas);

        return view('livewire.asignar-carga', compact('cargas'));
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function save()
    {
        $this->validate();

        foreach ($this->cargasSelected as $item) {

            DB::table('cargalectiva_carga')->insert([
                'cargalectiva_id' => $this->cargaLectivaId,
                'carga_id' => $item
            ]);
        }

        $this->resetForm();
        $this->emitTo('show-carga-lectiva-carga', 'render_table_carga_lectiva_carga');
        $this->emit('alertMixin', 'success', 'Cargas agregadas exitosamente');
    }

    public function updatingIsOpen()
    {
        if ($this->isOpen == false) {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset([
            'isOpen',
            'cargasSelected'
        ]);

        //Validations
        $this->resetValidation('cargasSelected');
        $this->resetErrorBag('cargasSelected');
    }
}
