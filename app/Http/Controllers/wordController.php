<?php

namespace App\Http\Controllers;

use App\Models\Condicione;
use App\Models\DeclaracionJurada;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Storage;

class wordController extends Controller
{
    public function downloadDeclaracion($id)
    {

        $declaracion = DeclaracionJurada::findOrfail($id);

        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('plantillaDeclaracionJurada.docx');

        //Variables
        $phpWord->setValues([
            'name' => $declaracion->docente->user->name,
            'condicion' => $declaracion->docente->condicione->descripcion,
            'categoria' => $declaracion->docente->categoria->descripcion,
            'modalidad' => $declaracion->docente->modalidade->descripcion,
            'facultad' => $declaracion->docente->escuela->facultad->descripcion,
            'escuela' => $declaracion->docente->escuela->descripcion,
            'dni' => $declaracion->docente->user->dni
        ]);

        //Save to path
        $pathToSave = 'storage/documents/Declaracion.docx';
        $phpWord->saveAs($pathToSave);

        //DownLoad Document Generate
        $file_path = public_path('storage/documents/Declaracion.docx');
        return response()->download($file_path);
    }
}
