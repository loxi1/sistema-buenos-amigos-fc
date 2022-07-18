<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cuentaxcobrar;

class Cuentasxcobrarmensualiades extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuentasxcobrar = Cuentaxcobrar::leftJoin('socios','cuentaxcobrars.socios_id','=','socios.id')
                                        ->leftJoin('aperturaranios','cuentaxcobrars.aperturaranio_id','=','aperturaranios.id')
                                        ->leftJoin('aperturarmes','cuentaxcobrars.aperturarmes_id','=','aperturarmes.id')
                                        ->leftJoin('personas','socios.persona_id','=','personas.id')
                                        ->leftJoin('tipo_documentos','tipo_documentos.tipo_documentos_id','=','personas.tipo_documentos_id')
                                        ->leftJoin('cobranzaestados','cuentaxcobrars.cobranzaestados_id','=','cobranzaestados.id')
                                        ->select('cuentaxcobrars.id','personas.nombres', 'personas.apellidos', 'tipo_documentos','numero_documento','monto_cobrar','monto_cobrado','monto_pendiente','cobranzaestados_id','cobranzaestados.estadocobros','aperturaranios.anio','mes')
                                        ->where('tipo_movimiento_id', '=', 4)
                                        ->get()->toArray(); 
        return view('backend.cuentasxcobrarmensualidad.index',compact('cuentasxcobrar'));
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
        //
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
}
