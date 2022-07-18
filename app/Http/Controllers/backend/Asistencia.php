<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aperturaranio;
use App\Models\Aperturarmes;
use Illuminate\Support\Facades\DB;
use App\Models\Asistenciapartido;
use App\Models\Aperturarpartido;
use App\Models\Socio;
use App\Models\Arbitro;
use App\Models\Cuentaxcobrar;
use App\Models\Cuentaxpagar;
use App\Models\Cuentasxpagardetalle;
use App\Models\Cuentasxcobrardetalle;
use App\Models\Tipo_tarjeta;
use App\Models\Kardex;
use App\Models\Tipomovimiento;
use App\Models\Listaganadores;
use App\Models\Cancha;

class Asistencia extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aperturaranios = Aperturaranio::where('estado','Activo')
                                        ->latest()
                                        ->first();
        
        $anio = (int) date("Y");
        $envapertura  = 0;
        $aperturarmes = 0;
        $nombmes = "";
        $losmeses = null;
        $partidoapertura = null;

        $mes = $anio."-".date("m")."-01";
        
        if(!empty($aperturaranios['id']))
        {
            $envapertura = $anio;
            
            $mesaper = Aperturarmes::where('aperturaranio_id',$aperturaranios['id'])
                                        ->where('estado',1)
                                        ->select('id','mes')
                                        ->orderByDesc('mes')
                                        ->get()->toArray();
            
            if(!empty($mesaper[0]['id']))
            {
                foreach($mesaper as $vv)
                {
                    $numes = (int) date("m",strtotime($vv['mes']));
                    $losmeses[$vv['id']]['mes'] = $vv['mes'];
                    $losmeses[$vv['id']]['mestext']= getmes($numes);
                }
                $aperturarmes = $mes;
            }

            $partidoapertura = Aperturarpartido::leftJoin('aperturarmes','aperturarpartidos.aperturarmes_id','=','aperturarmes.id')
                                        ->where('aperturaranio_id',$aperturaranios['id'])
                                        ->where('aperturarmes.estado',1)
                                        ->select('aperturarpartidos.id','fecha_partido','monto_recaudado','monto_para_club','monto_para_apuesta','arbitro_id','cantidad_horas','pago_arbitraje','pago_cancha','aperturarpartidos.estado')
                                        ->orderByDesc('fecha_partido')
                                        ->get()->toArray();

            $arbitro = Arbitro::leftJoin('personas','personas.id','=','arbitros.persona_id')
                                        ->selectRaw('arbitros.id, concat_ws(",",personas.nombres, personas.apellidos) as nombres')
                                        ->where('arbitros.estado', 'Activo')
                                        ->orderBy('personas.nombres')
                                        ->orderBy('personas.apellidos')
                                        ->get()->toArray();
            if(!empty($arbitro[0]['id']))
            {
                foreach($arbitro as $vv)
                {
                    $arbitro[$vv['id']] = $vv['nombres'];
                }
            }
        }
        
        $data['envapertura'] = $envapertura;
        $data['aperturarmes'] = $aperturarmes;
        $data['losmeses'] = $losmeses;
        $data['partidoapertura'] = $partidoapertura;
        $data['arbitros'] = !empty($arbitro) ? $arbitro : [];
        return view('backend.asistencia.index',compact('data'));
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
        $data = (!empty($id)) ? $this->ver_lista_apertura_dia($id) : [];
        return view('backend.asistencia.show',compact('data'));
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
        
    }

    /**
     * Visualizar las asistencias
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function validaraperturarpartido(Request $request, $id)
    {
        $partid = [];
        if(!empty($id))
        {
            $partid = Aperturarpartido::where('aperturarmes_id',$id)
                                        ->orderBy('fecha_partido')
                                        ->get()->pluck('fecha_partido');
            if(!empty($partid))
            {
                foreach($partid as $vv)
                {
                    $exit[$vv] = $vv;
                }
            }
        }

        $rq = $request->all();
        
        if(!empty($rq['fechai']) && !empty($rq['fechaf']))
        {
            $fechi = $rq['fechai'];
            $str = strtotime($rq['fechai']);
            
            $allday = [];
            $strctual = strtotime(date("Y-m-d"));
            while($fechi!=$rq['fechaf'])
            {
                $fechi = date("Y-m-d",$str);

                if($str>=$strctual)
                    $allday[$fechi] = $fechi;

                $str = strtotime("+1 day", $str);
            }
            
            if(!empty($exit))
            {
                $losdias = array_diff($allday, $exit);
            }
        }

        $mensaje = !empty($partid) ? "Encontro datos" : "No Encontro";
        $estado = !empty($partid) ? 1 : 0;
        $selec = !empty($losdias) ? (date("d-m-Y",strtotime(array_key_first($losdias)))) : false;

        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'partidos'=>$partid,'select'=>$selec]);
    }

    public function saveaperturarpartido(Request $request, $id)
    {
        $rq = $request->all();
        $mensaje = 'Error al Guardar';
        $estado = 0;
        $rta = 0;
        if(!empty($id) && !empty($rq['_fechai']))
        {
            $fech = $rq['_fechai'];
            $apertpart = Aperturarpartido::where('aperturarmes_id',$id)
                                            ->where(function ($query) use ($fech) {
                                                $query->where('fecha_partido', 'LIKE', "%$fech%");
                                            })
                                            ->latest()
                                            ->first();
            if(!empty($apertpart['id']))
            {
                $mensaje = "Ya existe esta fecha: ".$fech;
            }
            else
            {
                $inse['aperturarmes_id'] = $id;
                $inse['fecha_partido'] = $fech;
                $data = Aperturarpartido::create($inse);
                $rta = !empty($data->id) ? $data->id : 0;
                $estado = ($rta > 0) ? 1 : 0;
                $mensaje = ($estado == 1) ? "Guardo Ok" : "No Guardo";
            }
        }
        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'rta'=>$rta]);
    }

    public function eliminarasistencia($id)
    {
        $asis = Asistenciapartido::where('id',$id)->select('aperturarpartidos_id')->latest()->first();
        $res=Asistenciapartido::find($id)->delete();
        //dd($asis['aperturarpartidos_id']);
        return redirect()->route('registrarasistencia',$asis['aperturarpartidos_id'])->with('mensaje','El Socio ha sido eliminada exitosamente');
    }

    public function saveasistencia(Request $request, $id)
    {
        $estado = 0;
        if(!empty($id))
        {
            $rq = $request->all();
            if(!empty($rq['_arbitroid']))
            {
                $upd['arbitro_id'] = $rq['_arbitroid'];
                $canthoras = !empty($rq['_canthoras']) ? $rq['_canthoras'] : 0;
                $precio = !empty($rq['_arbitroprecio']) ? $rq['_arbitroprecio'] : 0;
                $upd['pago_arbitraje'] = $precio*$canthoras;
                $upd['cantidad_horas'] = ($canthoras>0) ? $canthoras : null;
                $upd['estado'] = 2;
                $estado = Aperturarpartido::where('id', $id)->update($upd);
            }
        }
        $mensaje = ($estado==1) ? "Guardo Ok" : "No Guardo";
        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'id'=>$id]);
    }

    /**
     * $id -> $id apertura del mes
     * Se listan todo los socios inscritos en la tabla asistencia partidos y se busca si tiene deudas de tarje e inscripción
     */

    public function registrarasistencia($id)
    {
        $data['aperturapartidoid'] = $id;
        $partid = Aperturarpartido::leftJoin('aperturarmes','aperturarpartidos.aperturarmes_id','=','aperturarmes.id')
                                        ->where('aperturarpartidos.id',$id)
                                        ->select('fecha_partido','arbitro_id','pago_arbitraje','cancha_id','cantidad_horas','aperturarpartidos.aperturarmes_id','aperturaranio_id')
                                        ->first();

        if(!empty($partid['aperturaranio_id']))
        {
            $asistio = Asistenciapartido::where('asistenciapartidos.estado',1)
                                            ->leftJoin('socios','socios.id','=','asistenciapartidos.socios_id')
                                            ->leftJoin('personas','personas.id','=','socios.persona_id')
                                            ->where('aperturarpartidos_id',$id)
                                            ->select('asistenciapartidos.id','asistenciapartidos.socios_id','personas.nombres', 'personas.apellidos')
                                            ->get()->toArray();
            
            $tarjet = Cuentaxcobrar::where('asistenciapartidos.estado',1)
                                            ->leftJoin('asistenciapartidos','cuentaxcobrars.asistenciapartidos_id','=','asistenciapartidos.id')
                                            ->where('cuentaxcobrars.aperturaranio_id',$partid['aperturaranio_id'])
                                            ->whereIn('cuentaxcobrars.tipo_movimiento_id',[3,10])
                                            ->whereIn('cuentaxcobrars.cobranzaestados_id',[1,2])
                                            ->selectRaw('asistenciapartidos.socios_id,cuentaxcobrars.tipotarjeta_id,count(*) as cant')
                                            ->groupBy('asistenciapartidos.socios_id')
                                            ->groupBy('cuentaxcobrars.tipotarjeta_id')
                                            ->get()->toArray();

            $inscri = Cuentaxcobrar::where('asistenciapartidos.estado',1)
                                            ->leftJoin('asistenciapartidos','cuentaxcobrars.socios_id','=','asistenciapartidos.socios_id')
                                            ->where('cuentaxcobrars.aperturaranio_id',$partid['aperturaranio_id'])
                                            ->where('cuentaxcobrars.tipo_movimiento_id',2)
                                            ->whereIn('cuentaxcobrars.cobranzaestados_id',[1,2])
                                            ->select('asistenciapartidos.socios_id', 'cuentaxcobrars.monto_pendiente')
                                            ->get()->toArray();

            $arbitro = Arbitro::leftJoin('personas','personas.id','=','arbitros.persona_id')
                                            ->selectRaw('arbitros.id, concat_ws(",",personas.nombres, personas.apellidos) as nombres, precio')
                                            ->where('arbitros.estado', 'Activo')
                                            ->orderBy('personas.nombres')
                                            ->orderBy('personas.apellidos')
                                            ->get()->toArray();
            if(!empty($arbitro[0]['id']))
            {
                foreach($arbitro as $vv)
                {
                    $arbitros[$vv['id']] = $vv['nombres'];
                    $precios[$vv['id']] = $vv['precio'];
                }
            }
            
            if(!empty($tarjet[0]['socios_id']))
            {
                foreach($tarjet as $kk)
                {
                    $tarjetas[$kk['socios_id']][$kk['tipotarjeta_id']] = $kk['cant'];
                }
            }

            if(!empty($inscri[0]['socios_id']))
            {
                foreach($inscri as $kk)
                {
                    $inscripciones[$kk['socios_id']] = $kk['monto_pendiente'];
                }
            }
            
            $data['asistio'] = $asistio;
            $data['tarjetas'] = (!empty($tarjetas)) ? $tarjetas : [];
            $data['inscripciones'] = (!empty($inscripciones)) ? $inscripciones : [];
            $data['arbitros'] = !empty($arbitros) ? $arbitros : [];
            $data['precios'] = !empty($precios) ? $precios : [];
            $data['partidos'] = !empty($partid) ? $partid : [];        
            //dd($data);
            return view('backend/asistencia/registrarasistencia',compact('data'));
        }
        else
            return redirect()->route('asistencias.index');       
        
    }

    /**
     * Registra un socio
     * id -> id apertura de mes
     * _idsocio -> id socio
     */
    public function saveasistenciasocio(Request $request, $id)
    {
        $mensaje = "Error";
        $estado = 0;
        $rta = [];
        $rq = $request->all();
        if(!empty($id) && !empty($rq['_idsocio']))
        {
            $asistio = Asistenciapartido::where('aperturarpartidos_id',$id)
                                        ->where('socios_id',$rq['_idsocio'])
                                        ->count();
            if(!$asistio)
            {
                $inse['aperturarpartidos_id'] = $id;
                $inse['socios_id'] = $rq['_idsocio'];
                $data = Asistenciapartido::create($inse);

                if(!empty($data->id))
                {
                    $estado = 1;
                    $mensaje = "Guardo Ok";
                    $tarjet = Cuentaxcobrar::where('socios_id',$rq['_idsocio'])
                                        ->whereIn('tipo_movimiento_id',[3,10])
                                        ->whereIn('estado',[1,2])
                                        ->selectRaw('tipotarjeta_id,count(*) as cant')
                                        ->groupBy('tipotarjeta_id')
                                        ->get()->toArray();
                    
                    if(!empty($tarjet[0]))
                    {
                        foreach($tarjet as $vv)
                        {
                            $tarjetas[$vv['tipotarjeta_id']] = $vv['cant'];
                        }
                    }

                    $deuda = Cuentaxcobrar::where('socios_id',$rq['_idsocio'])
                                        ->select('monto_pendiente')
                                        ->where('cuentaxcobrars.tipo_movimiento_id',2)
                                        ->whereIn('cuentaxcobrars.estado',[1,2])
                                        ->get()->toArray();

                    $socios = Socio::leftJoin('personas','personas.id','=','socios.persona_id')
                                        ->selectRaw('concat_ws(", ",personas.apellidos, personas.nombres) as nombres')
                                        ->where('socios.estado',1)
                                        ->where('socios.id',$rq['_idsocio'])
                                        ->get()->toArray();
                }
                else
                {
                    $mensaje = "No Guardo";
                }           
            }
            else
                $mensaje = "Ya Agrego a este Socio";
        }

        $rta['t_amar'] = !empty($tarjetas['1']) ? $tarjetas['1'] : 0;
        $rta['t_roja'] = !empty($tarjetas['2']) ? $tarjetas['2'] : 0;
        $rta['deuda'] = !empty($deuda[0]['monto_pendiente']) ? $deuda[0]['monto_pendiente'] : '-';
        $rta['asisid'] = !empty($data->id) ? $data->id : 0;
        $rta['nombre'] = !empty($socios[0]['nombres']) ? $socios[0]['nombres'] : 0;

        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'rta'=>$rta]);
    }

    /**
     * Se listan los socios que ya estan jugando
     * $id -> $id apertura del aperturarpartidos
     * 
     */
    public function registrarpartido($id)
    {
        $data = (!empty($id)) ? $this->ver_lista_apertura_dia($id) : [];
        return view('backend.asistencia.registrarpartido',compact('data'));
    }
    
    /**
     * Información para registrar partido y ver la apertura de dia de juego
     * Se muestra la información para la vista
     */
    public function ver_lista_apertura_dia($id=null)
    {
        $data['aperturapartidoid'] = $id;
        $partid = Aperturarpartido::where('id',$id)
                                        ->select('fecha_partido','arbitro_id','pago_arbitraje','cancha_id','cantidad_horas','monto_para_apuesta','monto_para_club','monto_recaudado','pago_cancha')
                                        ->latest()
                                        ->first();

        $asistio = Asistenciapartido::where('asistenciapartidos.estado',1)
                                        ->leftJoin('socios','socios.id','=','asistenciapartidos.socios_id')
                                        ->leftJoin('personas','personas.id','=','socios.persona_id')
                                        ->select('asistenciapartidos.id','asistenciapartidos.socios_id','personas.nombres','socios.aperturaranio_id','personas.apellidos','asistenciapartidos.socios_id','es_ganador')
                                        ->where('aperturarpartidos_id',$id)
                                        ->get()->toArray();

        $arbitro = Arbitro::leftJoin('personas','personas.id','=','arbitros.persona_id')
                                        ->selectRaw('arbitros.id, concat_ws(",",personas.nombres, personas.apellidos) as nombres, precio')
                                        ->where('arbitros.estado', 'Activo')
                                        ->orderBy('personas.nombres')
                                        ->orderBy('personas.apellidos')
                                        ->get()->toArray();

        $cancha = Cancha::where('estado',1)->pluck('cancha','id')->toArray();

        $preciocancha = Cancha::where('estado',1)->pluck('precio','id')->toArray();
        
        $tarjet = Asistenciapartido::rightJoin('cuentaxcobrars','asistenciapartidos.id','=','cuentaxcobrars.asistenciapartidos_id')
                                        ->selectRaw('asistenciapartidos.id, cuentaxcobrars.tipotarjeta_id, count(cuentaxcobrars.socios_id) as cant')
                                        ->where('asistenciapartidos.estado',1)
                                        ->where('asistenciapartidos.aperturarpartidos_id',$id)
                                        ->groupBy('asistenciapartidos.id')
                                        ->groupBy('cuentaxcobrars.tipotarjeta_id')
                                        ->get()->toArray();
        if(!empty($tarjet[0]['id']))
        {
            foreach($tarjet as $vv)
            {
                $tarjetas[$vv['id']][$vv['tipotarjeta_id']] = $vv['cant'];
            }
        }
        
        if(!empty($arbitro[0]['id']))
        {
            foreach($arbitro as $vv)
            {
                $arbitros[$vv['id']] = $vv['nombres'];
                $precios[$vv['id']] = $vv['precio'];
            }
        }
        $data['asistio'] = $asistio;
        $data['arbitros'] = !empty($arbitros) ? $arbitros : [];
        $data['precios'] = !empty($precios) ? $precios : [];
        $data['partidos'] = !empty($partid)? $partid: [];
        $data['tarjetas'] = !empty($tarjetas)? $tarjetas: [];
        $data['canchas'] = !empty($cancha)? $cancha: '';
        $data['preciocanchas'] = !empty($preciocancha)? $preciocancha: [];
        return $data;
    }
    /**
     * Registra falta de los jugadores mientras se esta jugando
     * $id Socio de la tabla asistenciapartidos (id)
     */
    public function saveasistenciafalta(Request $request, $id)
    {
        $estado = 0;
        $cant = 0;
        $rq = $request->all();
        if(!empty($id) && !empty($rq['_tipo']))
        {
            $tarjeta = Tipo_tarjeta::where('estado',1)
                                        ->where('id',$rq['_tipo'])
                                        ->select('precio')
                                        ->latest()
                                        ->first();
            
            $asistio = Asistenciapartido::leftJoin('aperturarpartidos','aperturarpartidos.id','=','asistenciapartidos.aperturarpartidos_id')
                                        ->leftJoin('aperturarmes','aperturarmes.id','=','aperturarpartidos.aperturarmes_id')
                                        ->select('asistenciapartidos.socios_id','aperturarpartidos.aperturarmes_id','asistenciapartidos.aperturarpartidos_id','aperturarmes.aperturaranio_id')
                                        ->where('asistenciapartidos.estado',1)
                                        ->where('asistenciapartidos.id',$id)
                                        ->get()->toArray();
            
            $inse = !empty($asistio[0]) ? $asistio[0] : [];
            $inse['asistenciapartidos_id'] = $id;
            $inse['tipo_movimiento_id'] = ($rq['_tipo'] == 1) ? 3 : 10;
            $inse['tipotarjeta_id'] = $rq['_tipo'];
            $inse['monto_cobrar'] = !empty($tarjeta['precio']) ? $tarjeta['precio'] : null;
            $inse['monto_pendiente'] = $inse['monto_cobrar'];
            $inse['cobranzaestados_id'] = 1;

            $data = Cuentaxcobrar::create($inse);
            $estado = !empty($data->id) ? 1 : $estado;

            $cant = Cuentaxcobrar::where('asistenciapartidos_id',$id)
                                    ->where('tipotarjeta_id',$rq['_tipo'])
                                    ->count();

        }
        $mensaje = ($estado == 1) ? "Registro falta Ok": "No registro";

        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'cant'=>$cant]);
    }

    /**
     * Es gandador del partido
     * $id Socio de la tabla asistenciapartidos (id)
     */

    public function saveasistenciagandor(Request $request, $id)
    {
        $estado = 0;
        $mensaje = "Error al Guardar";
        $rq = $request->all();
        if(!empty($id) && !empty($rq['_ganador']))
        {
            $upd['es_ganador'] = $rq['_ganador'];
            $estado = Asistenciapartido::where('id', $id)->update($upd);
            if($estado==1)
                $mensaje = ($estado==1 && $rq['_ganador']==2) ? "Si es Ganador": "No es ganador";
        }
        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje]);
    }

    /**
     * Finalizar partido
     * guarda arbitro, cantidad horas y monto total
     * gurada cobro_arbitro, cobro_monto_club y monto de la apuesta
     * Se registra ingreso x cobro arbitro, ingreso x cobro para el club
    */
    public function saveterminarpartido(Request $request, $id)
    {
        $estado = 0;
        $mensaje = "No Guardo";
        if(!empty($id))
        {
            $rq = $request->all();
            if(!empty($rq['_arbitroid']) && !empty($rq['_arbitroprecio']) && !empty($rq['_canchaid']) && !empty($rq['_canchaprecio']) && !empty($rq['_canthoras']))
            {
                $cant = Asistenciapartido::where('aperturarpartidos_id', $id)->count();
                if($cant >0)
                {
                    $canthoras = $rq['_canthoras'];
                    $precio = $rq['_arbitroprecio'];
                    $preciocancha = $rq['_canchaprecio'];

                    $m_reca = 12*$cant;
                    $m_p_cl = 2*$cant;
                    $p_a_bi = $precio*$canthoras;
                    $p_c_ha = $preciocancha*$canthoras;
                    $m_p_ap = (10*$cant)-($p_a_bi+$p_c_ha);

                    $upd['arbitro_id'] = $rq['_arbitroid'];
                    $upd['cancha_id'] = $rq['_canchaid'];
                    $upd['pago_arbitraje'] = $p_a_bi;
                    $upd['cantidad_horas'] = $canthoras;
                    $upd['monto_recaudado'] = $m_reca;
                    $upd['monto_para_club'] = $m_p_cl;
                    $upd['monto_para_apuesta'] = $m_p_ap;
                    $upd['pago_cancha'] = $p_c_ha;
                    $upd['estado'] = 3;
                    $estado = Aperturarpartido::where('id', $id)->update($upd);
                    if($estado)
                    {
                        //Asistenciapartido
                        $apertpart = Aperturarpartido::leftJoin('aperturarmes','aperturarmes.id','=','aperturarpartidos.aperturarmes_id')
                                        ->select('aperturarmes.aperturaranio_id','aperturarpartidos.aperturarmes_id', 'fecha_partido as fecha_ingreso', 'aperturarpartidos.id as aperturarpartidos_id')
                                        ->where('aperturarpartidos.id',$id)
                                        ->get()->toArray();

                        if(!empty($apertpart[0]))
                        {
                            //Cobrar ARBITRAJE
                            $idtipmov = 8;
                            $monto = $p_a_bi;
                            $rta = $this->cuentas_x_cobrar($apertpart[0], $monto, $idtipmov);

                            //Pagar ARBITRAJE
                            $idtipmov = 6;
                            $rta = $this->cuentas_x_pagar($apertpart[0], $monto, $idtipmov);

                            //Cobrar CANCHA
                            $idtipmov = 9;
                            $monto = $p_c_ha;
                            $rta = $this->cuentas_x_cobrar($apertpart[0], $monto, $idtipmov);

                            //Pagar CANCHA
                            $idtipmov = 7;
                            $rta = $this->cuentas_x_pagar($apertpart[0], $monto, $idtipmov);

                            //Cobrar Apuesta
                            $idtipmov = 11;
                            $monto = $m_p_ap;
                            $rta = $this->cuentas_x_cobrar($apertpart[0], $monto, $idtipmov);

                            //Pagar Apuesta
                            $idtipmov = 12;
                            $rta = $this->cuentas_x_pagar($apertpart[0], $monto, $idtipmov);

                            //Cobrar Ingresos para el Club
                            $idtipmov = 13;
                            $monto = $m_p_cl;
                            $rta = $this->cuentas_x_cobrar($apertpart[0], $monto, $idtipmov);
                        }

                        $ganadores = Asistenciapartido::leftJoin('aperturarpartidos','aperturarpartidos.id','=','asistenciapartidos.aperturarpartidos_id')
                                        ->leftJoin('aperturarmes','aperturarmes.id','=','aperturarpartidos.aperturarmes_id')
                                        ->select('asistenciapartidos.id as asistenciapartidos_id','asistenciapartidos.socios_id','asistenciapartidos.aperturarpartidos_id','aperturarpartidos.aperturarmes_id','aperturarmes.aperturaranio_id')
                                        ->where('asistenciapartidos.estado',1)
                                        ->where('aperturarpartidos.id',$id)
                                        ->where('es_ganador',2)
                                        ->get()->toArray();
                                        
                        $cantganadores = !empty($ganadores[0]) ? count($ganadores) : 1;
                        $sum = 0;
                        $rec = number_format($m_p_ap/$cantganadores, 2, '.', '');

                        if(!empty($ganadores[0]['asistenciapartidos_id']))
                        {
                            $adi = [];
                            foreach($ganadores as $kk=>$vv)
                            {
                                $adi= $vv;
                                $adi['monto_ganado'] = (($kk+1)==count($ganadores)) ? ($m_p_ap-$sum) : $rec;
                                $gana = Listaganadores::create($adi);
                                $sum += $adi['monto_ganado'];
                            }
                        }
                    }
                }
                else
                    $mensaje = "No registo Asistentes";
            }
        }
        $mensaje = ($estado==1) ? "Guardo Ok" : "No Guardo";
        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'id'=>$id]);
    }

    /**
     * Cuentas x Cobrar
     */
    public function cuentas_x_cobrar($data = null, $monto=null, $idtipmov=0)
    {
        $rta = ['estado'=>0,'mensaje'=>'Error'];
        if(!empty($data) && !empty($monto) && $idtipmov)
        {
            $inse = $data;
            $inse['tipo_movimiento_id'] = $idtipmov;
            $inse['monto_cobrar'] = $monto;
            $inse['monto_cobrado'] = $inse['monto_cobrar'];
            $inse['monto_pendiente'] = $inse['monto_cobrar'];
            $inse['cobranzaestados_id'] = 4;
            $data = Cuentaxcobrar::create($inse);

            if(!empty($data->id))
            {
                $inse = [];
                $inse['fecha_ingreso'] = !empty($data['fecha_ingreso']) ? $data['fecha_ingreso'] : date("Y-m-d");
                $inse['cuentaxcobrars_id'] = $data->id;
                $inse['monto_cobrado'] = $monto;
                $data = Cuentasxcobrardetalle::create($inse);

                if(!empty($data->id))
                {
                    $inse = [];
                    $inse['tipomovimientos_id'] = $idtipmov;
                    $inse['documento_id'] = $data->id;
                    $inse['monto'] = $monto;
                    $rta = $this->savekardex($inse);
                }
                else
                    $rta['mensaje'] = "No guardo detalle Cuenta x Cobrar";
            }
            else
                $rta['mensaje'] = "No guardo Cuenta x Cobrar";
        }
        return $rta;
    }
    
    /**
     * Cuentas x Pagar
     */
    public function cuentas_x_pagar($data = null, $monto=null, $idtipmov=0)
    {
        $rta = ['estado'=>0,'mensaje'=>'Error'];
        if(!empty($data) && !empty($monto) && $idtipmov)
        {
            $inse = $data;
            $inse['tipo_movimiento_id'] = $idtipmov;
            $inse['monto_pagar'] = $monto;
            $inse['monto_pagado'] = $inse['monto_pagar'];
            $inse['monto_pendiente'] = $inse['monto_pagar'];
            $inse['pagoestados_id'] = 4;
            $data = Cuentaxpagar::create($inse);

            if(!empty($data->id))
            {
                $inse = [];
                $inse['fecha_ingreso'] = !empty($data['fecha_ingreso']) ? $data['fecha_ingreso'] : date("Y-m-d");
                $inse['cuentaxpagars_id'] = $data->id;
                $inse['monto_pagado'] = $monto;
                $data = Cuentasxpagardetalle::create($inse);

                if(!empty($data->id))
                {
                    $inse = [];
                    $inse['tipomovimientos_id'] = $idtipmov;
                    $inse['documento_id'] = $data->id;
                    $inse['monto'] = $monto;
                    $rta = $this->savekardex($inse);
                }
                else
                    $rta['mensaje'] = "No guardo detalle Cuenta x Pagar";
            }
            else
                $rta['mensaje'] = "No guardo Cuenta x Pagar";
        }
        return $rta;
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

    public function asistenciasocio(Request $request, $id)
    {
        $rq = $request->all();
        $like = !empty($rq['query']) ? $rq['query'] : null;
        $output = '';
        if(!empty($rq['_query']))
        {
            $sql = $rq['_query'];
            $asistio = Asistenciapartido::where('estado',1)
                                            ->where('aperturarpartidos_id',$id)
                                            ->select('socios_id')
                                            ->get()->toArray();
            
            $socios = Socio::leftJoin('personas','personas.id','=','socios.persona_id')
                            ->select('socios.id','personas.nombres', 'personas.apellidos')
                            ->where('socios.estado','Activo')
                            ->where(function ($query) use ($sql) {
                                $query->where('personas.nombres', 'LIKE', "%$sql%")
                                      ->orWhere('personas.apellidos', 'LIKE', "%$sql%");
                            });
            if(!empty($asistio))
                $socios = $socios->whereNotIn('socios.id',$asistio);

            $socios = $socios->get()->toArray();                            

            $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
            if(!empty($socios[0]['id']))
            {
                foreach($socios as $vv)
                {
                    $output .= '<li id="socio'.$vv['id'].'" sociosid="'.$vv['id'].'" class="list-group-item">'.$vv['apellidos'].', '.$vv['nombres'].'</li>';
                }
            }
            else
                $output .= '<li class="list-group-item">'.'No existen registros'.'</li>';
            $output .= '</ul>';

        }
        
        return response()->json(['output'=>$output]);
    }
}
