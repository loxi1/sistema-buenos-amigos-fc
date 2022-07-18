<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cuentaxcobrar;
use App\Models\Cobranzaestado;

class Reporteinscripciones extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados = Cobranzaestado::where('estado','!=',3)->pluck('estadocobros','id')->toArray();
        $cutaincripcion = Cuentaxcobrar::selectRaw('cobranzaestados_id, count(*) as cantidad')
                                        ->where('estado',1)
                                        ->where('tipo_movimiento_id',2)
                                        ->where('cobranzaestados_id','!=',3)
                                        ->groupBy('cobranzaestados_id')
                                        ->get()->toArray();
        
        if(!empty($cutaincripcion[0]['cobranzaestados_id']))
        {
            foreach($cutaincripcion as $ky=>$vv)
            {
                $cantidad[$ky] = $vv['cantidad'];
                $estadocobranza[$ky] = !empty($estados[$vv['cobranzaestados_id']]) ? $estados[$vv['cobranzaestados_id']] : "";
            }
        }
        
        $data['cantidad'] = !empty($cantidad) ? json_encode($cantidad) : null;
        $data['estadocobranza'] = !empty($estadocobranza) ? ($estadocobranza) : [];
        
        return view('backend.reporteinscripcion.index',compact('data'));
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
