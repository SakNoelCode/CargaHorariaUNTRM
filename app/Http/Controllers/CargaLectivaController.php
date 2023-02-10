<?php

namespace App\Http\Controllers;

use App\Models\CargaLectiva;
use Illuminate\Http\Request;

class CargaLectivaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
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
        $cargaLectiva = CargaLectiva::findorFail($id);
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
        $cargaLectiva = CargaLectiva::findorFail($id);
        return view('docente.cargalectiva.cargahoraria', [
            'cargaLectiva' => $cargaLectiva
        ]);
    }
}
