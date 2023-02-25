<?php

namespace App\Http\Controllers;

use App\Models\CargaLectiva;
use App\Models\DeclaracionJurada;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Style\Font;

class wordController extends Controller
{
    public function downloadDeclaracion($id)
    {

        // https://phpword.readthedocs.io/en/latest/intro.html  Documentacion PHPWord

        $declaracion = DeclaracionJurada::findOrfail($id);

        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('templates/plantillaDeclaracionJurada.docx');

        $fecha = Carbon::now();

        mb_internal_encoding('UTF-8');
        //Variables
        $phpWord->setValues([
            'name' => mb_strtoupper($declaracion->docente->user->name),
            'condicion' => $declaracion->docente->condicione->descripcion,
            'categoria' => mb_strtoupper($declaracion->docente->categoria->descripcion),
            'modalidad' => mb_strtoupper($declaracion->docente->modalidade->descripcion),
            'facultad' => $declaracion->docente->escuela->facultad->descripcion,
            'escuela' => $declaracion->docente->escuela->descripcion,
            'dni' => $declaracion->docente->user->dni,
            'ciudad' => 'Bagua',
            'dia' => $fecha->day,
            'mes' => $this->getMes($fecha->month),
            'year' => $fecha->year
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
        $idCurso = 1;
        $idCarga = 2;
        $arrayCurso = [];
        $arrayCarga = [];
        $totalCurso = 0;
        //$totalCarga = 0;
        $totalHorasCurso = 0;
        $totalHorasCarga = 0;
        $totalHoras = 0;
        $fecha = Carbon::now();
        mb_internal_encoding('UTF-8'); //Soporte para carácteres especiales 

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

        $cargas = DB::table('cargalectiva_carga as clc')
            ->join('cargas as c', 'c.id', 'clc.carga_id')
            ->select('c.titulo', 'c.descripcion as dCarga', 'clc.descripcion as descripcionCarga', 'clc.cantidad_horas')
            ->where('cargalectiva_id', $cargaLectiva->id)
            ->get();

        //Utilizando la plantilla 
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('templates/plantillaDeclaracionCargaHoraria.docx');

        //Creando la data 
        $phpWord->setValues([
            'universidad' => 'UNIVERSIDAD NACIONAL TORIBIO RODRIGUEZ DE MENDOZA DE AMAZONAS',
            'facultad' =>  mb_strtoupper($cargaLectiva->declaracionJurada->docente->escuela->facultad->descripcion),
            'escuela' =>  mb_strtoupper($cargaLectiva->declaracionJurada->docente->escuela->descripcion),
            'nombreDocente' => $cargaLectiva->declaracionJurada->docente->user->name,
            'condicionDocente' => $cargaLectiva->declaracionJurada->docente->condicione->descripcion,
            'categoriaDocente' => $cargaLectiva->declaracionJurada->docente->categoria->descripcion,
            'md' => $cargaLectiva->declaracionJurada->docente->modalidade->descripcion,
            'hm' => $cargaLectiva->declaracionJurada->docente->modalidade->horas,
            'semestre' => $cargaLectiva->declaracionJurada->periodo->descripcion,
            'inicioSemestre' => Carbon::createFromFormat('Y-m-d', $cargaLectiva->declaracionJurada->periodo->inicio_periodo)->format('d-m-Y'),
            'finSemestre' => Carbon::createFromFormat('Y-m-d', $cargaLectiva->declaracionJurada->periodo->fin_periodo)->format('d-m-Y'),
            'ciudad' => 'Bagua',
            'numFecha' => $fecha->day,
            'mesFecha' => $this->getMes($fecha->month),
            'yearFecha' => $fecha->year
        ]);

        foreach ($cursos as $item) {
            $totalCurso = $item->horas_teoria + $item->horas_practica;
            $values = [[
                'i' => $idCurso,
                'nombreCurso' => $item->nombre,
                'tip' => $item->tipo,
                'cic' => $item->descripcion,
                'sec' => mb_strtoupper($item->desSeccion),
                'num' => $item->numero_alumnos,
                'ht' => $item->horas_teoria,
                'hp' => $item->horas_practica,
                'tot' => $totalCurso
            ]];
            $idCurso++;
            $totalHorasCurso += $totalCurso;
            array_push($arrayCurso, $values);
        }

        foreach ($cargas as $item) {
            $values = [[
                'idCarga' => $idCarga,
                'tituloCarga' => mb_strtoupper($item->titulo),
                'dCarga' => $item->dCarga,
                'descripcionCarga' => $item->descripcionCarga,
                'totC' => $item->cantidad_horas
            ]];
            $idCarga++;
            $totalHorasCarga += $item->cantidad_horas;
            array_push($arrayCarga, $values);
        }

        //Convertir arreglo tridimensional en bidimesional
        $bidimensionalArrayCurso = [];
        foreach ($arrayCurso as $item) {
            $bidimensionalArrayCurso = array_merge($bidimensionalArrayCurso, $item);
        }

        $bidimensionalArrayCarga = [];
        foreach ($arrayCarga as $item) {
            $bidimensionalArrayCarga = array_merge($bidimensionalArrayCarga, $item);
        }

        $phpWord->cloneRowAndSetValues('i', $bidimensionalArrayCurso);
        $phpWord->cloneRowAndSetValues('idCarga', $bidimensionalArrayCarga);

        $totalHoras = $totalHorasCarga + $totalHorasCurso;
        $phpWord->setValue('total', $totalHoras);

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
                $mes = 'enero';
                break;
            case 2:
                $mes = 'febrero';
                break;
            case 3:
                $mes = 'marzo';
                break;
            case 4:
                $mes = 'abril';
                break;
            case 5:
                $mes = 'mayo';
                break;
            case 6:
                $mes = 'junio';
                break;
            case 7:
                $mes = 'julio';
                break;
            case 8:
                $mes = 'agosto';
                break;
            case 9:
                $mes = 'septiembre';
                break;
            case 10:
                $mes = 'octubre';
                break;
            case 11:
                $mes = 'noviembre';
                break;
            case 12:
                $mes = 'diciembre';
                break;
        }

        return $mes;
    }
}
