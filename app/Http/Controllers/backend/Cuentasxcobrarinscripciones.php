<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cuentaxcobrar;
use App\Models\Cuentasxcobrardetalle;
use App\Models\Tipomovimiento;
use App\Models\Kardex;
use App\Models\Cobranzaestado;
class Cuentasxcobrarinscripciones extends Controller
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
                            ->leftJoin('personas','socios.persona_id','=','personas.id')
                            ->leftJoin('tipo_documentos','tipo_documentos.tipo_documentos_id','=','personas.tipo_documentos_id')
                            ->leftJoin('cobranzaestados','cuentaxcobrars.cobranzaestados_id','=','cobranzaestados.id')
                            ->select('cuentaxcobrars.id','personas.nombres', 'personas.apellidos', 'tipo_documentos','numero_documento','monto_cobrar','monto_cobrado','monto_pendiente','cobranzaestados_id','cobranzaestados.estadocobros','aperturaranios.anio')
                            ->where('tipo_movimiento_id', '=', 2)
                            ->get()->toArray();        
        return view('backend.cuentasxcobrarinscripcion.index',compact('cuentasxcobrar'));
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
    /**
     * $id ->Cuenta Pagar
     * _fechai = Fecha de Ingreso
     * _monto = monto que se cobra
     */
    public function savecobroinscripcion(Request $request, $id)
    {
        $rta = ['estado'=>0,'mensaje'=>"Error en los datos"];
        $rq = $request->all();
        if(!empty($id) && !empty($rq['_fecha']) && !empty($rq['_monto']))
        {
            //Insertar Detalle Cuenta x Cobrar
            $inse = ['cuentaxcobrars_id'=>$id,'monto_cobrado'=>$rq['_monto'],'fecha_ingreso'=>$rq['_fecha']];
            $data = Cuentasxcobrardetalle::create($inse);
            //Valor del monto a cobrar
            $cue = Cuentaxcobrar::select('id','monto_cobrar','tipo_movimiento_id')
                                ->where('id',$id)
                                ->first();

            
            if(!empty($data->id) && !empty($cue['id']))
            {
                $estado = 1;
                //Inserta Kardex el movimiento de ingreso x cobro de inscripción tipo movimeinto
                $inse = [];
                $inse['tipomovimientos_id'] = $cue['tipo_movimiento_id'];
                $inse['documento_id'] = $data->id;
                $inse['monto'] = $rq['_monto'];
                $rta = $this->savekardex($inse);

                //Suma total de los monto_cobrado
                $det = Cuentasxcobrardetalle::selectRaw('cuentaxcobrars_id, sum(monto_cobrado) as sum')
                                    ->where('cuentaxcobrars_id',$id)
                                    ->groupBy('cuentaxcobrars_id')
                                    ->first();                

                $monto_cobrar = $cue['monto_cobrar'];                
                $monto_cobrado = $det['sum'];
                $monto_pendiente = $cue['monto_cobrar']-$monto_cobrado;
                $cobranzaestados_id = ($monto_cobrar==$monto_cobrado) ? 4 : 2;
                $monto_pendiente = ($monto_pendiente == 0) ? null : $monto_pendiente;
                
                $up['monto_cobrado'] = $monto_cobrado;
                $up['monto_pendiente'] = $monto_pendiente;
                $up['cobranzaestados_id'] = $cobranzaestados_id;

                //Actualizar valores Cuenta x Cobrar
                $estado = Cuentaxcobrar::where('id', $id)->update($up);
                $up['fecha_ingreso'] = date("d/m/Y",strtotime($rq['_fecha']));
                $up['monto_cobrar'] = $monto_cobrar;

                $estadocobro = Cobranzaestado::select('estadocobros')->where('id',$up['cobranzaestados_id'])->first();
                $up['estadocobros'] = (!empty($estadocobro['estadocobros'])) ? $estadocobro['estadocobros'] : "";

                if($estado==1)
                    $rta['mensaje'] = "Guardo Ok";
                else
                    $rta = ['estado'=>0,'mensaje'=>"NO Registro"];
            }
        }
        $rta['data'] = !empty($up) ? $up : [];
        return response()->json($rta);
    }

    /**
     * Guardar elementos del kardex
     * variables: tipomovimientos_id, documento_id, monto
     */
    public function savekardex($data = null)
    {
        $rta = ['estado'=>0,'mensaje'=>'Error'];
        if(!empty($data['tipomovimientos_id']) && !empty($data['documento_id']) && !empty($data['monto']))
        {
            $tipomov = Tipomovimiento::where('id',$data['tipomovimientos_id'])->first();
            $kardex = Kardex::where('estado',1)->select('saldo_actual')->orderByDesc('id')->first();
            $saldo = !empty($kardex['saldo_actual']) ? $kardex['saldo_actual'] : 0;

            if($tipomov['tipo'] == "Salida")
                $saldo -= $data['monto'];
            else
                $saldo += $data['monto'];
            
            if($saldo >=0)
            {
                $inse = $data;
                $inse['tipo'] = $tipomov['tipo'];
                $inse['abreviatura'] = $tipomov['abreviatura'];
                $inse['saldo_actual'] = $saldo;
                $data = Kardex::create($inse);

                if(!empty($data->id))
                    $rta = ['estado'=>1,'mensaje'=>'Ok'];
                else
                    $rta['mensaje'] = 'No guardo';
            }
            else
                $rta['mensaje'] = 'Sando Negativo';
        }
        return $rta;
    }

    /**
     * @parm in $id->cuentaxcobrar
     * Buscar si existen cobros
     */
    public function vercuentaxcobrar(Request $request, $id)
    {
        $estado = 0;
        $mensaje = "No guardo";
        $data['montopendiente'] = '';
        if(!empty($id))
        {
            $cue = Cuentaxcobrar::select('id','monto_cobrar','monto_cobrado','monto_pendiente','cobranzaestados_id')
                                 ->where('id',$id)
                                 ->first();
            if($cue['id'])
            {
                $estado = 1;
                $mensaje = "Ver cuenta";
                $det = Cuentasxcobrardetalle::selectRaw('id, monto_cobrado, DATE_FORMAT(fecha_ingreso, "%d/%m/%Y") as fechai')
                                            ->where('cuentaxcobrars_id',$id)
                                            ->get()->toArray();
                $html = '<tr><td colspan="2"><h4 class="text-center">No hay Cobros</h1></td></tr>';                            
                if(!empty($det[0]['id']))
                {                    
                    $mensaje = "Detalle de la cuenta";
                    $html = '';
                    foreach($det as $vv)
                    {
                        $html .='<tr><td class="fechai">'.$vv['fechai'].'</td><td>'.$vv['monto_cobrado'].'</td></tr>';
                    }
                }
            }
            else
                $mensaje = "No tiene estado Pendiente o Parcial";

            $data['html'] = !empty($html) ? $html : "";
            $data['cue'] = !empty($cue) ? $cue : "";            
        }
        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'data'=>$data]); 
    }
}
