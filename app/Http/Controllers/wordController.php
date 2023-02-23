<?php

namespace App\Http\Controllers;

use App\Models\CargaLectiva;
use App\Models\Condicione;
use App\Models\DeclaracionJurada;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class wordController extends Controller
{
    public function downloadDeclaracion($id)
    {

        // https://phpword.readthedocs.io/en/latest/intro.html  Documentacion PHPWord

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

    public function downloadDeclaracionCargaHoraria($id)
    {
        //Variables
        $id = 1;
        $arrayCurso = [];
        $totalCurso = 0;
        $fecha = Carbon::now();
        $fechaMes = $this->getMes($fecha->month);

        //Consulta a la base de datos
        $cargaLectiva = CargaLectiva::findOrfail($id);

        $cursos = DB::table('cargalectiva_curso as clc')
            ->join('cursos as c', 'c.id', 'clc.curso_id')
            ->join('ciclos as ciclo', 'ciclo.id', 'clc.ciclo_id')
            ->join('seccions as seccion', 'seccion.id', 'clc.seccion_id')
            ->select(
                'c.nombre',
                'c.tipo',
                'ciclo.descripcion',
                'seccion.descripcion as desSeccion',
                'clc.numero_alumnos',
                'clc.horas_teoria',
                'clc.horas_practica'
            )
            ->where('cargalectiva_id', $cargaLectiva->id)
            ->get();

        //Utilizando la plantilla 
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('templates/plantillaDeclaracionCargaHoraria.docx');

        //Creando la data 
        $phpWord->setValues([
            'universidad' => 'UNIVERSIDAD NACIONAL TORIBIO RODRIGUEZ DE MENDOZA DE AMAZONAS',
            'facultad' => $cargaLectiva->declaracionJurada->docente->escuela->facultad->descripcion,
            'escuela' => $cargaLectiva->declaracionJurada->docente->escuela->descripcion,
            'nombreDocente' => $cargaLectiva->declaracionJurada->docente->user->name,
            'condicionDocente' => $cargaLectiva->declaracionJurada->docente->condicione->descripcion,
            'categoriaDocente' => $cargaLectiva->declaracionJurada->docente->categoria->descripcion,
            'md' => $cargaLectiva->declaracionJurada->docente->modalidade->descripcion,
            'hm' => $cargaLectiva->declaracionJurada->docente->modalidade->horas,
            'semestre' => $cargaLectiva->declaracionJurada->periodo->descripcion,
            'inicioSemestre' => $cargaLectiva->declaracionJurada->periodo->inicio_periodo,
            'finSemestre' => $cargaLectiva->declaracionJurada->periodo->fin_periodo,
            'ciudad' => 'Bagua',
            'numFecha' => $fecha->day,
            'mesFecha' => $fechaMes,
            'yearFecha' => $fecha->year
        ]);

        foreach ($cursos as $item) {
            $totalCurso = $item->horas_teoria + $item->horas_practica;
            $values = [[
                'id' => $id,
                'nombreCurso' => $item->nombre,
                'tipo' => $item->tipo,
                'ciclo' => $item->descripcion,
                'seccion' => $item->desSeccion,
                'numalu' => $item->numero_alumnos,
                'ht' => $item->horas_teoria,
                'hp' => $item->horas_practica,
                'tot' => $totalCurso
            ]];
            $id++;
            array_push($arrayCurso, $values);
        }

        $phpWord->cloneRowAndSetValues('id', $arrayCurso);

        
        //Save to path
        $pathToSave = 'storage/documents/CargaHoraria.docx';
        $phpWord->saveAs($pathToSave);

        //DownLoad Document Generate
        $file_path = public_path('storage/documents/CargaHoraria.docx');
        return response()->download($file_path);
    }

    public function getMes($month)
    {
        $mes = '';
        switch ($month) {
            case 1:
                $mes = 'Enero';
                break;
            case 2:
                $mes = 'Febrero';
                break;
            case 3:
                $mes = 'Marzo';
                break;
            case 4:
                $mes = 'Abril';
                break;
            case 5:
                $mes = 'Mayo';
                break;
            case 6:
                $mes = 'Junio';
                break;
            case 7:
                $mes = 'Julio';
                break;
            case 8:
                $mes = 'Agosto';
                break;
            case 9:
                $mes = 'Septiembre';
                break;
            case 10:
                $mes = 'Octubre';
                break;
            case 11:
                $mes = 'Noviembre';
                break;
            case 12:
                $mes = 'Diciembre';
                break;
        }

        return $mes;
    }
}
