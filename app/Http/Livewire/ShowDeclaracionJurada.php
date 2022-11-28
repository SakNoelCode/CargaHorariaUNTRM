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
    public $idDeclaracion, $nameDocente, $periodo, $estado, $documento;
    public $idDocumento;

    protected $queryString = [
        'numberOfRecords' => ['except' => "5"]
    ];

    protected $listeners = [
        'render'
    ];

    protected $rules = [
        'documento' => 'required|mimes:pdf,docx|max:1024'
    ];

    public $numeracion = 1;

    public function render()
    {
        //$declaraciones = DeclaracionJurada::orderBy('id','desc')->paginate(5);
        $declaraciones = DeclaracionJurada::where('docente_id', Auth::user()->docente->id)
            ->orderBy('id', 'desc')
            ->paginate($this->numberOfRecords);

        return view('livewire.show-declaracion-jurada', ['declaraciones' => $declaraciones]);
    }

    public function edit(DeclaracionJurada $declaracionJurada)
    {

        // dd($declaracionJurada);
        //$this->declaracion = $declaracionJurada;
        $this->idDeclaracion = $declaracionJurada->id;
        $this->nameDocente = $declaracionJurada->docente->user->name;
        $this->periodo = $declaracionJurada->periodo->descripcion;
        $this->estado = $declaracionJurada->estado;
        $this->documento = $declaracionJurada->documento;
        $this->idDocumento = rand();

        $this->isOpen = true;
    }

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

        $this->cleanFields();

        $this->emit('alertBox', 'Documento enviado', 'Espere la revisión de su documento', 'success');
    }

    //descargar documento enviado
    public function download()
    {
        $file_path = public_path('storage/documents/' . $this->documento);
        return response()->download($file_path);
    }

    public function cleanFields()
    {
        $this->reset([
            'isOpen'
        ]);

        //Resetear Validacion
        $this->resetValidation('documento');
        $this->resetErrorBag('documento');
    }

    //Ciclo de vida(resetear la pagina cada vez que busquemos un valor)
    public function UpdatingNumberOfRecords()
    {
        $this->resetPage();
    }
}
