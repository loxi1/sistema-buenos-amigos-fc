<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Persona;
use App\Models\Provincia;
use App\Models\Tipo_documento;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $personas = Persona::leftJoin('departamentos','departamentos.id','=','personas.departamentos_id')
                            ->leftJoin('provincias','provincias.id','=','personas.provincias_id')
                            ->leftJoin('distritos','distritos.id','=','personas.distritos_id')
                            ->select('personas.id','nombres', 'apellidos', 'sexo', 'tipo_documentos_id', 'numero_documento', 'fecha_nacimiento', 'celular', 'direccion', 'referencia', 'departamentos.departamentos', 'provincias.provincias', 'distritos.distritos')
                            ->get()->toArray();
        return view('backend.persona.index',compact('personas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $documentos = ['' => 'Tipo Documento']+Tipo_documento::pluck('tipo_documentos','tipo_documentos_id')->toArray();
        $digitos = Tipo_documento::pluck('digitos','tipo_documentos_id')->toArray();
        $departamentos = ['' => 'SELECCIONE DEPARTAMENTO']+Departamento::pluck('departamentos','id')->toArray();
        $provincias = ['' => 'SELECCIONE PROVINCIA']+Provincia::where('departamentos_id',15)->get()->pluck('provincias','id')->toArray();
        $distritos = ['' => 'SELECCIONE DISTRITO']+Distrito::where('provincias_id',161)->get()->pluck('distritos','id')->toArray();
        return view('backend.persona.create',compact('documentos','digitos','departamentos','provincias','distritos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Para guardar los registros
        $request->validate(
            ['nombres'=>'required',
            'apellidos'=>'required']
        );
        $persona = Persona::create($request->all());
        return redirect()->route('personas.edit',$persona)->with('mensaje','Registro de manera Correcta');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        //visualizar un registro registros
        return view('backend.persona.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        //Editar Registro
        $documentos = ['' => 'Tipo Documento']+Tipo_documento::pluck('tipo_documentos','tipo_documentos_id')->toArray();
        $digitos = Tipo_documento::pluck('digitos','tipo_documentos_id')->toArray();
        $departamentos = ['' => 'SELECCIONE DEPARTAMENTO']+Departamento::pluck('departamentos','id')->toArray();
        $provincias = [];
        $distritos = [];
        if(!empty($persona->departamentos_id))
        {
            $provincias = ['' => 'SELECCIONE PROVINCIA']+Provincia::where('departamentos_id',$persona->departamentos_id)->get()->pluck('provincias','id')->toArray();
            if(!empty($persona->provincias_id))
            {
                $distritos = ['' => 'SELECCIONE DISTRITO']+Distrito::where('provincias_id',$persona->provincias_id)->get()->pluck('distritos','id')->toArray();
            }
        }
        return view('backend.persona.edit',compact('persona','documentos','digitos','departamentos','provincias','distritos'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        //Lllevar a la vista
        $request->validate(
            ['nombres'=>'required',
            'apellidos'=>'required']
        );
        $persona->update($request->all());
        return redirect()->route('personas.edit',$persona)->with('mensaje','Actualizo de manera Correcta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        //
        $persona->delete();
        return redirect()->route('personas.index')->with('mensaje','La Persona ha sido eliminada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function obtenerprovincia($id)
    {
        $provincias = Provincia::where('departamentos_id',$id)->get();
        return response()->json(['rta'=>$provincias]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function obtenerdistrito($id)
    {
        $distritos = Distrito::where('provincias_id',$id)->get();
        return response()->json(['rta'=>$distritos]);
    }
}
