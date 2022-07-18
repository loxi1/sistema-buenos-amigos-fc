<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\Tipo_documento;
use App\Models\Persona;
use App\Models\Socio_historial;
use App\Models\Tipo_socio;
use App\Models\Cuentaxcobrar;
use App\Models\Aperturaranio;
use phpDocumentor\Reflection\Types\Null_;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aperturaranio = Aperturaranio::where('estado','Activo')
                                        ->latest()
                                        ->first();
        
        $documentos = ['' => 'Tipo Documento']+Tipo_documento::pluck('tipo_documentos','tipo_documentos_id')->toArray();
        $socios = Socio::leftJoin('personas','personas.id','=','socios.persona_id')
                            ->leftJoin('tipo_socios','tipo_socios.id','=','socios.tiposocios_id')
                            ->select('socios.id','personas.nombres', 'personas.apellidos', 'tipo_socios.tipo_socios', 'tiposocios_id', 'tipo_socios.precio','anio','celular')
                            ->where('socios.estado','Activo')
                            ->get()->toArray();

        $tiposocios = ['' => 'Tipo Socio']+Tipo_socio::pluck('tipo_socios','id')->toArray();
        $precios = Tipo_socio::pluck('precio','id')->toArray();
        
        $personas = Persona::leftJoin('tipo_documentos','tipo_documentos.tipo_documentos_id','=','personas.tipo_documentos_id')
                            ->leftJoin('socios','personas.id','=','socios.persona_id')
                            ->select('personas.id','nombres', 'apellidos', 'numero_documento', 'tipo_documentos.tipo_documentos', 'socios.estado')
                            ->get()->toArray();
                         
        return view('backend.socio.index',compact('socios','documentos','personas','tiposocios','precios','aperturaranio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $personas = Persona::leftJoin('tipo_documentos','tipo_documentos.tipo_documentos_id','=','personas.tipo_documentos_id')
                            ->leftJoin('socios','personas.id','=','socios.persona_id')
                            ->select('personas.id','nombres', 'apellidos', 'numero_documento', 'tipo_documentos.tipo_documentos', 'socios.estado')
                            ->get()->toArray();
        return view('backend.socio.create',compact('personas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json(['estado'=>1,'mensaje'=>100,'socioxx'=>$request]);
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
        return response()->json(['estado'=>1,'mensaje'=>$id,'socioxx'=>$request]);
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
    
    //Guardar socio llega como parametro persona_id
    public function savesocios($id)
    {
        $socios = Socio::where('socios.persona_id',$id)->get()->toArray();
        
        $aperturaranio = Aperturaranio::where('estado','=','Activo')
                                        ->latest()
                                        ->first();
                                        
        $anio = (!empty($aperturaranio['anio'])) ? $aperturaranio['anio'] : date("Y");
        $aperturaranio_id = (!empty($aperturaranio['id'])) ? $aperturaranio['id'] : null;

        $fecha = date("Y-m-d H:i:s");
        $esantiguo = Socio_historial::where('persona_id',$id)->get()->count();
        $tiposocio = Tipo_socio::get()->toArray();
        
        $tipo = ($esantiguo>0) ? $tiposocio[0] : $tiposocio[1];

        $datasocio = ['tiposocios_id'=>$tipo['id'],'anio'=>$anio,'aperturaranio_id'=>$aperturaranio_id,'estado'=>'Activo'];

        $idsocio = (!empty($socios[0]['id'])) ? $socios[0]['id'] : 0;
        
        if($idsocio >0)
        {
            //Actualizar socio
            $upd = $datasocio;
            $upd['updated_at'] = $fecha;
            $data = Socio::where('id',$idsocio)->update($upd);
        }
        else
        {
            //Agregar nuevo socios
            $inse = $datasocio;
            $inse['persona_id'] = $id;
            $inse['created_at'] = $fecha;
            $data = Socio::create($inse);
            $idsocio = (!empty($data->id)) ? $data->id : 0;
        }        
        
        if($idsocio > 0)
        {
            //Agregar Historial de socios
            $inse = $datasocio;
            $inse['socio_id'] = $idsocio;
            $inse['persona_id'] = $id;
            $inse['fecha_ingreso'] = $fecha;
            $data = Socio_historial::create($inse);

            //Agregar Cuentas x Pagar
            $inse = [];
            $inse['aperturaranio_id'] = $aperturaranio_id;
            $inse['socios_id'] = $idsocio;
            $inse['tipo_movimiento_id'] = 2;
            $inse['monto_cobrar'] = !empty($tipo['precio']) ? $tipo['precio'] : 0;
            $inse['monto_pendiente'] = $inse['monto_cobrar'];
            $inse['created_at'] = $fecha;
            $inse['cobranzaestados_id'] = 1; //Siempre se crea con estado Pendiente
            $data = Cuentaxcobrar::create($inse);
        }
        $estado = !empty($data['id']) ? 1 : 0;
        $mensaje = !empty($data['id']) ? "El Socio se agrego con Éxito" : "No Guardo";

        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'socio'=>$datasocio]);
    }

    public function updatesocio(Request $request, $id)
    {
        if(!empty($id))
        {
            $rq = $request->all();
            $idsocio = $id;
            $tiposocio = $rq['tiposocios_id'];

            $tiposocio = Tipo_socio::where('id',$tiposocio)->get()->toArray();

            $tipo = $tiposocio[0];
            $fecha = date("Y-m-d H:i:s");
            $upd = ['tiposocios_id'=>$tipo['id'],'updated_at'=>$fecha];
            $data = Socio::where('id',$idsocio)->update($upd);

            $upd = [];
            $upd['monto_pagar'] = $tipo['precio'];
            $upd['monto_pendiente'] = $upd['monto_pagar'];
            $data = Cuentaxcobrar::where('socios_id',$idsocio)->where('cobranzaestados_id',1)->update($upd);
        }
        $estado = !empty($data) ? 1 : 0;
        $mensaje = !empty($data) ? "Se edito el tipo de Socio" : "No Guardo";
        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'data'=>$data]);
    }
}
