<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cancha;

class Canchas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $canchas = Cancha::orderBy('cancha')->get()->toArray();
        return view('backend.cancha.index',compact('canchas'));
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
        $rq = $request->all();
        $rta = ['estado'=>0,'mensaje'=>'No guardo'];
        if(!empty($rq['_precio']) && !empty($rq['_cancha']))
        {
            $iup['cancha'] = $rq['_cancha'];
            $iup['precio'] = $rq['_precio'];
            $iup['celular'] = !empty($rq['_celular']) ? $rq['_celular'] : null;
            $iup['estado'] = 1;
            $canchaid = !empty($rq['_canchaid']) ? $rq['_canchaid'] : 0;

            if(!$canchaid)
            {
                $data = Cancha::create($iup);
                if(!empty($data->id))
                    $rta = ['estado'=>1,'mensaje'=>'Guardo Ok'];
                else
                    $rta['mensaje'] = "No Guardo";
            }
            else
            {
                $estado = Cancha::where('id', $canchaid)->update($iup);
                if($estado)
                    $rta = ['estado'=>1,'mensaje'=>'Actualizo Ok'];
                else
                    $rta['mensaje'] = "No Edito";
            }
        }
        return response()->json($rta);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rta = ['estado'=>0,'mensaje'=>'Error'];
        if(!empty($id))
        {
            $estado = Cancha::where('id', $id)->update(['estado'=>2]);
            if($estado)
                $rta = ['estado'=>1,'mensaje'=>'Elimino Ok'];
            else
                $rta['mensaje'] = "No Elimino";
        }
        return response()->json($rta);
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
