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
    public $isOpen_edit = false;
    public $numberOfRecords = "5";
    public $idDeclaracion, $nameDocente, $periodo, $estado, $documento;

    protected $queryString = [
        'numberOfRecords' => ['except'=> "5"]
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

        $this->isOpen_edit = true;
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

        $this->reset([
            'isOpen_edit',
            'documento'
        ]);

        $this->emit('alertBox', 'Documento enviado', 'Espere la revisión de su documento', 'success');
    }

    public function download()
    {
        $file_path = public_path('storage/documents/' . $this->documento);
        return response()->download($file_path);
    }
}
