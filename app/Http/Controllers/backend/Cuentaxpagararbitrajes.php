<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cuentaxpagar;

class Cuentaxpagararbitrajes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuentasxpagar = Cuentaxpagar::leftJoin('aperturarpartidos','cuentaxpagars.aperturarpartidos_id','=','aperturarpartidos.id')
                            ->leftJoin('arbitros','aperturarpartidos.arbitro_id','=','arbitros.id')
                            ->leftJoin('personas','arbitros.persona_id','=','personas.id')
                            ->leftJoin('aperturarmes','aperturarpartidos.aperturarmes_id','=','aperturarmes.id')
                            ->leftJoin('aperturaranios','aperturarmes.aperturaranio_id','=','aperturaranios.id')
                            ->leftJoin('cobranzaestados','cuentaxpagars.pagoestados_id','=','cobranzaestados.id')
                            ->select('cuentaxpagars.id','nombres','apellidos','monto_pagar','monto_pagado','monto_pendiente','pagoestados_id','cobranzaestados.estadopagos','fecha_ingreso','aperturaranios.anio')
                            ->where('tipo_movimiento_id', '=', 6)
                            ->get()->toArray();

        return view('backend.cuentaxpagararbitraje.index',compact('cuentasxpagar'));
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
