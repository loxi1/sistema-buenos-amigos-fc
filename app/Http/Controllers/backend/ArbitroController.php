<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Arbitro;
use App\Models\Persona;

class ArbitroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $arbitros = Arbitro::leftJoin('personas','personas.id','=','arbitros.persona_id')
                            ->leftJoin('tipo_documentos','tipo_documentos.tipo_documentos_id','=','personas.tipo_documentos_id')
                            ->select('arbitros.id','personas.nombres', 'personas.apellidos', 'tipo_documentos', 'personas.tipo_documentos_id', 'precio','numero_documento','celular')
                            ->where('arbitros.estado', 'Activo')
                            ->orderBy('personas.nombres')
                            ->orderBy('personas.apellidos')
                            ->get()->toArray();
        return view('backend.arbitro.index',compact('arbitros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $arbitros = Persona::leftJoin('arbitros','personas.id','=','arbitros.persona_id')
                            ->leftJoin('tipo_documentos','tipo_documentos.tipo_documentos_id','=','personas.tipo_documentos_id')
                            ->select('personas.id','personas.nombres', 'personas.apellidos', 'tipo_documentos','precio','personas.tipo_documentos_id', 'arbitros.persona_id','numero_documento','celular','arbitros.estado')
                            ->get()->toArray();
        return view('backend.arbitro.create',compact('arbitros'));
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
    //Guardar Arbitro llega como parametro persona_id
    public function savearbitros(Request $request, $id)
    {
        $arbitros = Arbitro::where('arbitros.persona_id',$id)->get()->toArray();
        $fecha = date("Y-m-d H:i:s");
        $rq = $request->all();
        $precio = $rq['precio'];
        
        $idarbitro = (!empty($arbitros[0]['id'])) ? $arbitros[0]['id'] : 0;
        $dataarbitro  = array();
        $data  = array();
        $estado = 0;
        if($precio > 0)
        {
            $dataarbitro = ['precio'=>$precio,'estado'=>'Activo'];
            if($idarbitro > 0)
            {
                //Actualizar arbitro
                $upd = $dataarbitro;
                $upd['updated_at'] = $fecha;
                $data = Arbitro::where('id',$idarbitro)->update($upd);
                $estado = !empty($data) ? 1 : 0;
            }
            else
            {
                //Agregar nuevo socios
                $inse = $dataarbitro;
                $inse['persona_id'] = $id;
                $inse['created_at'] = $fecha;
                $data = Arbitro::create($inse);
                $idarbitro = (!empty($data->id)) ? $data->id : 0;
                $estado = !empty($data->id) ? 1 : 0;
            }
        }
        
        $mensaje = !empty($estado) ? "El Arbitro se agrego con Éxito" : "No Guardo";

        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'arbitro'=>$estado]);
    }

    public function updatearbitro(Request $request, $id)
    {
        if($id >0)
        {
            $fecha = date("Y-m-d H:i:s");
            $rq = $request->all();
            
            $estado = !empty($rq['estado']) ? 'Activo' : 'Inactivo';

            $upd = ['updated_at'=>$fecha,'estado'=>$estado];
            if(isset($rq['precio']))
                $upd['precio'] = $rq['precio'];

            $data = Arbitro::where('id',$id)->update($upd);
        }

        $estado = !empty($data) ? 1 : 0;
        $mensaje = !empty($data) ? "El Arbitro se edito con Éxito" : "No Edito";

        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'arbitro'=>$estado]);
    }
}
