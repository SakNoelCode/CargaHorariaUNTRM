<?php

namespace App\Http\Livewire;

use App\Models\CargaLectiva;
use App\Models\DeclaracionJurada;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDeclaracionJuradaJefe extends Component
{
    use WithPagination;
    //Variables
    public $numeracion = 1, $numberOfRecords = "5";
    public $showModalEdit = false, $showModalView = false, $checkBoxObservaciones = false;

    //Variables del la declaracion jurada
    public $idDeclaracion, $nameDocente, $periodo, $observaciones, $estado;

    /**
     * Validation rules
     * 
     * @return array
     */
    protected function rules()
    {
        return [
            'estado' => 'required'
        ];
    }


    public function render()
    {
        $declaraciones = DeclaracionJurada::orderBy('id', 'desc')
            ->where('estado_enviado', 1)
            ->orWhere('estado', 'observado')
            ->orWhere('estado', 'rechazado')
            ->paginate($this->numberOfRecords);

        return view('livewire.show-declaracion-jurada-jefe', compact('declaraciones'));
    }

    /**
     * Dowload document
     * 
     * @return response
     */
    public function download(DeclaracionJurada $declaracion)
    {
        $declaracion = $declaracion;
        $file_path = public_path('storage/documents/' . $declaracion->documento);
        return response()->download($file_path);
    }

    /**
     * Abre el modal para editar el elemento
     */
    public function edit(DeclaracionJurada $declaracion)
    {
        $this->resetFields();
        $this->resetValidationFields();

        //Asignar valores a las variables
        $this->idDeclaracion = $declaracion->id;
        $this->nameDocente = $declaracion->docente->user->name;
        $this->periodo = $declaracion->periodo->descripcion;
        $this->observaciones = $declaracion->observaciones;
        $this->estado = $declaracion->estado;

        if ($this->estado == 'enviado') {
            $this->estado = '';
            $this->showModalEdit = true;
        } else {
            $this->showModalView = true;
        }
    }

    /**
     * resetea todos los campos a su valor original
     */
    public function resetFields()
    {
        $this->reset([
            'showModalEdit',
            'showModalView',
            'idDeclaracion',
            'nameDocente',
            'periodo',
            'observaciones',
            'estado',
            'checkBoxObservaciones'
        ]);
    }

    /**
     * Elimina y resetea todas las bolsas de errores
     */
    public function resetValidationFields()
    {
        $this->resetValidation('estado');
        $this->resetErrorBag('estado');
    }

    /**
     * Acción al dar clic en el botón de cancelar o cerrar
     */
    public function cancelar()
    {
        $this->showModalEdit = false;
    }


    /**
     * Función que valida todos los campos y realiza una actualización en la base
     * de datos
     */
    public function update()
    {

        $this->validate();

        //--------------------------------Modificar valores en la base de datos y actualizar
        $DeclaracionJurada = DeclaracionJurada::findorFail($this->idDeclaracion);
        $DeclaracionJurada->estado = $this->estado;
        if ($this->observaciones) {
            $DeclaracionJurada->observaciones = $this->observaciones;
        }
        //Si la declaracion jurada es observada o rechazada
        if ($this->estado == 'observado' || $this->estado == 'rechazado') {
            $DeclaracionJurada->estado_enviado = 0;
        }
        //Si la declaracion jurada es aceptada
        if ($this->estado == 'aprobado') {
            CargaLectiva::insert(['declaracionJurada_id' => $this->idDeclaracion]);
        }

        $DeclaracionJurada->update();
        //---------------------------------------------------------------------------------------

        //Cerrar el modal
        $this->showModalEdit = false;

        //Emitir evento a través de JavaScript(ver app.blade.php) para mostrar un mensaje
        $this->emit('alertBox', 'Documento revisado', 'Espere la respuesta del docente', 'success');

        //No es necesario renderizar a la tabla porque es automatico
    }

}
