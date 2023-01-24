<?php

namespace App\Http\Livewire;

use App\Models\DeclaracionJurada;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowDeclaracionJurada extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $isOpen = false;
    public $numberOfRecords = "5";
    public $numeracion = 1;
    public $idDeclaracion, $nameDocente, $periodo, $estado, $documento, $observaciones;
    public $idDocumento;

    /**
     * Hace posible una consulta a través del enlace con la variable numberofRecord excepto el numero 5
     */
    protected $queryString = [
        'numberOfRecords' => ['except' => "5"]
    ];

    /**
     * Listener, para la escucha de alguna llamada externa
     */
    protected $listeners = [
        'render'
    ];

    /**
     * Validation rules
     * @return array
     */
    protected $rules = [
        'documento' => 'required|mimes:pdf,docx|max:1024'
    ];

    public function render()
    {
        //$declaraciones = DeclaracionJurada::orderBy('id','desc')->paginate(5);
        $declaraciones = DeclaracionJurada::where('docente_id', Auth::user()->docente->id)
            ->orderBy('id', 'desc')
            ->paginate($this->numberOfRecords);

        return view('livewire.show-declaracion-jurada', ['declaraciones' => $declaraciones]);
    }

    /**
     * Modal que muestra datos de las declaraciones juradas
     */
    public function edit(DeclaracionJurada $declaracionJurada)
    {
        $this->resetValidationFields();
        $this->idDeclaracion = $declaracionJurada->id;
        $this->nameDocente = $declaracionJurada->docente->user->name;
        $this->periodo = $declaracionJurada->periodo->descripcion;
        $this->estado = $declaracionJurada->estado;
        $this->documento = $declaracionJurada->documento;
        if ($declaracionJurada->observaciones != '') {
            $this->observaciones = $declaracionJurada->observaciones;
        }else{
            $this->observaciones = 'Esta declaración no dispone de observaciones';
        }
        $this->idDocumento = rand();

        $this->isOpen = true;
    }

    /**
     * Función encargada de actualizar algunos valores en la base de datos
     */
    public function update()
    {
        $this->validate();

        $DeclaracionJurada = DeclaracionJurada::findorFail($this->idDeclaracion);

        //Manejo del archivo
        $filename = time() . $this->documento->getClientOriginalName();
        $this->documento->storeAs('documents', $filename, 'public');

        //Save to Declaracion
        $DeclaracionJurada->estado = 'enviado';
        $DeclaracionJurada->estado_enviado = 1;
        $DeclaracionJurada->documento = $filename;
        $DeclaracionJurada->save();

        $this->resetFields();

        $this->emit('alertBox', 'Documento enviado', 'Espere la revisión de su documento', 'success');
    }

    /**
     * Función que permite descargar el documento enviado
     */
    public function download()
    {
        $file_path = public_path('storage/documents/' . $this->documento);
        return response()->download($file_path);
    }


    /**
     * Función que nos permite restablecer los valores de algunas variables
     */
    public function resetFields()
    {
        $this->reset([
            'isOpen'
        ]);
    }

    /**
     * Resetea las bolsas de los errores
     */
    public function resetValidationFields()
    {
        $this->resetValidation('documento');
        $this->resetErrorBag('documento');
    }

    /**
     * Ciclo de vida(resetear la pagina cada vez que busquemos un valor)
     */
    public function UpdatingNumberOfRecords()
    {
        $this->resetPage();
    }
}
