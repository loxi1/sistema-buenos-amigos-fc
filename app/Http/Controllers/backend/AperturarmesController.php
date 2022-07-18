<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Aperturaranio;
use App\Models\Aperturarmes;
use App\Models\Cuentaxcobrar;
use Illuminate\Support\Facades\DB;
use App\Models\Datosistema;

class AperturarmesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $aperturaranios = Aperturaranio::where('estado','Activo')
                                        ->latest()
                                        ->first();
        
        $anio = (int) date("Y");
        $envapertura  = $anio;
        $aperturarmes = null;

        $mes = $anio."-".date("m")."-01";
        $nom = "";
        
        if(!empty($aperturaranios['anio']))
        {
            if($aperturaranios['anio']==$anio)
            {
                $envapertura = 0;
                $aperturarmes = Aperturarmes::where('estado','Activo')
                                            ->where('aperturaranio_id',$aperturaranios['id'])
                                            ->latest()
                                            ->first();
                
                if(!empty($aperturarmes['mes']))
                {
                    $aperturarmes = Aperturarmes::select('id','mes')
                                                    ->where('aperturaranio_id',$aperturaranios['id'])
                                                    ->orderByDesc('mes')
                                                    ->get()->toArray();
                    
                    if(!empty($aperturarmes[0]['id']))
                    {
                        foreach($aperturarmes as $vv)
                        {
                            $dia =(int) date("m",strtotime($vv['mes']));

                            $mis[$vv['id']] = getmes($dia);
                            if($vv['mes'] == $mes)
                                $mes = 0;
                        }
                    }
                }

                $dix = (int) date("m");
                $nom = getmes($dix);               
                

                $aperturarmes = isset($mis) ? $mis : null;
            }                
        }
        
        return view('backend.aperturarmes.index',compact('aperturarmes','mes','nom','envapertura'));            
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
     * Aperturar mes actual
     * @param int $id
     * @return \Illuminate\Http\Response
    */
    public function saveaperturarmes(Request $aperturmes, $id)
    {
        $user_id = Auth::id();
        $anio = date("Y");
        $mes = date("Y-m")."-01";
        $estado = 0;

        $anioaper = Aperturaranio::where('anio',$anio)
                                    ->where('estado','Activo')
                                    ->get()->toArray();
        if(!empty($anioaper[0]['id']))
        {
            $mesaper = Aperturarmes::where('aperturaranio_id',$anioaper[0]['id'])
                                        ->where('mes',"'".$mes."'")
                                        ->where('estado',1)
                                        ->get()->toArray();

            if(!empty($mesaper[0]['id'])){}
            else
            {
                $inse = ['aperturaranio_id'=>$anioaper[0]['id'],'user_id'=>$user_id,'mes'=>$mes];
            
                $data = Aperturarmes::create($inse);
                $estado = !empty($data->id) ? $data->id : 0;

                $cobromensual = Datosistema::where('estado','Activo')
                                        ->latest()
                                        ->first();
                if(!empty($cobromensual['cobromensual']) && $estado)
                {
                    $sql = "INSERT INTO cuentaxcobrars (aperturaranio_id,socios_id,tipo_movimiento_id,monto_cobrar,monto_pendiente,aperturarmes_id,cobranzaestados_id,created_at,updated_at) select socios.aperturaranio_id,socios.id,4,".$cobromensual['cobromensual'].",".$cobromensual['cobromensual'].",".$estado.",1,now(),now() from socios where socios.estado='Activo'";
                    $rta = DB::select( DB::raw($sql) );
                    $cantapemes = Cuentaxcobrar::where('estado',1)
                                                ->where('aperturarmes_id',$estado)
                                                ->count();
                    $estado = ($cantapemes>0) ? $estado : 0;
                }
            }
        }
        $mensaje = !empty($estado) ? "Se aperturo el mes Éxito" : "No Guardo";

        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'aperturames'=>$estado]);
    }
}
