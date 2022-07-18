<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Aperturaranio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Socio_historial;
use App\Models\Socio;
use Illuminate\Support\Facades\DB;
use App\Models\Aperturarmes;

class AperturaranioController extends Controller
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
        
        $anio = date("Y");
        $envapertura  = $anio;

        if(!empty($aperturaranios['anio']))
        {
            if($aperturaranios['anio']==$anio)
                $envapertura = 0;
        }

        $estilo = [['class'=>'info','icon'=>'calendar'],['class'=>'success','icon'=>'calendar-check'],['class'=>'warning','icon'=>'calendar-alt'],['class'=>'danger','icon'=>'calendar-plus']];
        
     
        $aperturaranios = DB::table('aperturaranios')
                        ->leftJoin('socio_historials','aperturaranios.id','=','socio_historials.aperturaranio_id')
                        ->select(DB::raw('aperturaranios.id, aperturaranios.anio,count(socio_historials.id) as cantidad'))
                        ->where('aperturaranios.estado', '=', 'Activo')
                        ->groupBy('aperturaranios.id','aperturaranios.anio')
                        ->get()->toArray();
                        
        return view('backend.aperturaranio.index',compact('aperturaranios','envapertura','estilo'));
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
        $socios = Socio_historial::leftJoin('personas','personas.id','=','socio_historials.persona_id')
                        ->leftJoin('departamentos','departamentos.id','=','personas.departamentos_id')
                        ->leftJoin('provincias','provincias.id','=','personas.provincias_id')
                        ->leftJoin('distritos','distritos.id','=','personas.distritos_id')
                        ->leftJoin('tipo_socios','tipo_socios.id','=','socio_historials.tiposocios_id')
                        ->rightJoin('aperturaranios','socio_historials.aperturaranio_id','=','aperturaranios.id')
                        ->leftJoin('tipo_documentos','tipo_documentos.tipo_documentos_id','=','personas.tipo_documentos_id')
                        ->select('socio_historials.id','personas.nombres', 'personas.apellidos','fecha_nacimiento','tipo_documentos.tipo_documentos','personas.numero_documento', 'tipo_socios.tipo_socios', 'tiposocios_id', 'tipo_socios.precio','aperturaranios.anio','celular', 'direccion', 'referencia', 'departamentos.departamentos', 'provincias.provincias', 'distritos.distritos')
                        ->where('aperturaranios.estado', '=', 1)
                        ->where('socio_historials.estado', '=', 1)
                        ->get()->toArray();
                        
        return view('backend.aperturaranio.ver',compact('socios'));
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

    public function saveaperturaranios(Request $aperturaranio, $id)
    {
        $user_id = Auth::id();
        $anio = date("Y");
        $estado = 0;
        $aperturar = Aperturaranio::where('anio',$anio)
                                    ->where('estado','Activo')
                                    ->get()->toArray();
                                    
        if(!empty($aperturar[0]['id'])){}
        else
        {
            $inse = ['anio'=>$anio,'user_id'=>$user_id];
            
            $data = Aperturaranio::create($inse);
            $estado = !empty($data->id) ? 1 : 0;

            $upd = [];
            $upd['tiposocios_id'] = 1;
            $upd['aperturaranio_id'] = null;
            $upd['estado'] = 'Inactivo';
            $data = Socio::where('estado','Activo')->update($upd);
        }

        $mensaje = !empty($estado) ? "Se aperturo Éxito" : "No Guardo";

        return response()->json(['estado'=>$estado,'mensaje'=>$mensaje,'arbitro'=>$estado]);
    }
}
