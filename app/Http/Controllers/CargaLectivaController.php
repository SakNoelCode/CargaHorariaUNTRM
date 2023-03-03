<?php

namespace App\Http\Controllers;

use App\Models\CargaHoraria;
use App\Models\CargaLectiva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CargaLectivaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //Comprobaciones
        $escuelajefe = auth()->user()->jefeDepartamento->escuela->id;
        $cargaLectivaCheck = DB::table('carga_lectivas as cl')
        ->join('declaracion_juradas as dj','dj.id','cl.declaracionJurada_id')
        ->join('docentes as d','d.id','dj.docente_id')
        ->join('escuelas as e','e.id','d.escuela_id')
        ->select('cl.id','e.id as idEscuela')
        ->where('e.id',$escuelajefe)
        ->where('cl.id',$id)
        ->first();   
           
        if($cargaLectivaCheck == null){
            return redirect()->route('error.401');
        }

        $cargaLectiva = CargaLectiva::findorFail($id);
        $docente = $cargaLectiva->declaracionJurada->docente;
        $declaracionJurada = $cargaLectiva->declaracionJurada;

        return view(
            'jefedepartamento.cargalectiva.create',
            [
                'docente' => $docente,
                'declaracionJurada' => $declaracionJurada,
                'cargaLectiva' => $cargaLectiva
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*
        $cargaLectiva =  CargaLectiva::findOrfail($id);
        $cargaLectiva->estado_asignado = 1;
        $cargaLectiva->update();

        return redirect()->route('cargasLectivasJefeDepartamento');*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cargaLectivaLlenar($id)
    {
        //Comprobaciones
        $docenteCheck = auth()->user()->docente->id;
        $cargaLectivaCheck = DB::table('carga_lectivas as cl')
        ->join('declaracion_juradas as dj','dj.id','cl.declaracionJurada_id')
        ->select('cl.id','cl.estado_terminado','dj.docente_id')
        ->where('cl.id',$id)
        ->where('cl.estado_asignado',1)
        ->where('dj.docente_id',$docenteCheck)
        ->first();        
        if($cargaLectivaCheck == null){
            return redirect()->route('error.401');
        }

        //Si se comprueba que no es nulo se continúa
        $cargaLectiva = CargaLectiva::findOrfail($id);
        $docente = $cargaLectiva->declaracionJurada->docente;
        $declaracionJurada = $cargaLectiva->declaracionJurada;

        return view(
            'docente.cargalectiva.create',
            [
                'docente' => $docente,
                'declaracionJurada' => $declaracionJurada,
                'cargaLectiva' => $cargaLectiva
            ]
        );
    }

    public function cargaLectivaHorario($id)
    {
        //Comprobaciones
        $docenteCheck = auth()->user()->docente->id;
        $cargaLectivaCheck = DB::table('carga_lectivas as cl')
        ->join('declaracion_juradas as dj','dj.id','cl.declaracionJurada_id')
        ->select('cl.id','cl.estado_terminado','dj.docente_id')
        ->where('cl.id',$id)
        ->where('cl.estado_terminado',1)
        ->where('dj.docente_id',$docenteCheck)
        ->first();   
        if($cargaLectivaCheck == null){
            return redirect()->route('error.401');
        }

        $cargaLectiva = CargaLectiva::findorFail($id);
        $cargaHoraria = CargaHoraria::where('cargalectiva_id',$cargaLectiva->id)->first();

        return view('docente.cargalectiva.cargahoraria', [
            'cargaLectiva' => $cargaLectiva,
            'cargaHoraria' => $cargaHoraria
        ]);
    }
}
