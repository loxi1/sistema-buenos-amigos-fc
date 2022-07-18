@extends('backend.layouts.app')
@section('css_contenido')
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{asset('backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('backend/plugins/toastr/toastr.min.css')}}">
<style>    
    .btn-app {
        height: auto !important;
        padding: 0 !important;
        margin: 0 !important;

    }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-9">
                    <h1>Listar Asistentes al Partidos</h1>
                </div>
                <div class="col-sm-3">
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                @php
                    $fechapartido = !empty($data['partidos']['fecha_partido']) ? date("d/m/Y",strtotime($data['partidos']['fecha_partido'])) : "";
                @endphp
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title" style="display: inline">Socios Presentes <em><b style="font-size: 20px;">{{$fechapartido}}</b></em></h3>
                    <a href="{{route('asistencias.index')}}" class="btn btn-sm btn-default float-right"><i class="fas fa-reply-all"> Atrás</i></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb_asistentes" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre Completo</th>
                                    <th>Tarjeta Amarilla</th>
                                    <th>Tarjeta Roja</th>
                                    <th>Es Ganador</th>
                                </tr>
                                </thead>
                                <tbody>
                    @if(!empty($data['asistio']))
                        @foreach($data['asistio'] as $kk=>$vv)
                            <tr asistiopartido="{{$vv['id']}}">
                                <td class="correlativo">{{ $kk+1 }}</td>
                                <td class="nombres">{{ $vv['apellidos'].", ".$vv['nombres'] }}</td>
                                <td class="text-center">
                            @php
                                $cant_a = !empty($data['tarjetas'][$vv['id']][1]) ? $data['tarjetas'][$vv['id']][1] : 0;
                                $cant_r = !empty($data['tarjetas'][$vv['id']][2]) ? $data['tarjetas'][$vv['id']][2] : 0;
                            @endphp        
                                    <a tipo="1" class="btn btn-app bg-warning savefalta"><span class="badge bg-info">{{$cant_a}}</span><i class="fas fa-bullhorn"></i></a>
                                </td>
                                <td>
                                    <a tipo="2" class="btn btn-app bg-danger savefalta"><span class="badge bg-info">{{$cant_r}}</span><i class="fas fa-bullhorn"></i></a>
                                </td>
                                <td>
                                    <div class="custom-control custom-switch text-center">
                                        <input type="checkbox" @if($vv['es_ganador']=='Si') checked @endif class="custom-control-input" id="esganador{{$vv['id']}}">
                                        <label class="custom-control-label" for="esganador{{$vv['id']}}"></label>
                                    </div
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="6"><h1 class="text-center">No hay asistentes</h1></td></tr>        
                    @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre Completo</th>
                                    <th>Tarjeta Amarilla</th>
                                    <th>Tarjeta Roja</th>
                                    <th>Es Ganador</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>                        
                    </div>
                    <!-- /.card-body -->
                </div>
               <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="display: inline">Pagar</h3>
                    </div>
                    <!-- /.card-header -->
                @php
                    $esarbitro = !empty($data['partidos']['arbitro_id']) ? $data['partidos']['arbitro_id'] : '';
                    $escancha = !empty($data['partidos']['cancha_id']) ? $data['partidos']['cancha_id'] : '';
                    $montoarbitro = !empty($data['partidos']['pago_arbitraje']) ? $data['partidos']['pago_arbitraje'] : '';
                    $canthoras = !empty($data['partidos']['cantidad_horas']) ? $data['partidos']['cantidad_horas'] : '';
                    $canchas = !empty($data['canchas']) ? $data['canchas'] : '';
                    $preciocancha = !empty($data['preciocancha']) ? $data['preciocancha'] : '';
                @endphp
                    <div class="card-body">
                        <div class="row">
                            <form>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                {!! Form::label('arbitro','Arbitro',['for'=>'inputArbitro'])  !!}
                                                {!! Form::select('arbitro',$data['arbitros'],$esarbitro,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="precioArbitro">Precio</label>
                                                <input type="number" readonly="" class="form-control" id="precioArbitro" placeholder="">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="precioTotal">Total</label>
                                                <input type="number" value="{{$montoarbitro}}" readonly="" class="form-control" id="precioTotal" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="cantidahora_">Horas</label>
                                                <input type="number" value="{{$canthoras}}" class="form-control" id="cantidahora_" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                {!! Form::label('cancha','Cancha',['for'=>'inputCancha'])  !!}
                                                {!! Form::select('cancha',$canchas,$escancha,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="precioCancha">Precio</label>
                                                <input type="number" readonly="" class="form-control" id="precioCancha" placeholder="0.00">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="precioTotalc">Total</label>
                                                <input type="number" readonly="" class="form-control" id="precioTotalc" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($data['precios'] as $ki=>$precio)
                                    <input type="hidden" class="precios_{{$ki}}" value="{{$precio}}">
                                @endforeach

                                @foreach ($data['preciocanchas'] as $ki=>$precio)
                                    <input type="hidden" class="precioscancha_{{$ki}}" value="{{$precio}}">
                                @endforeach
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-9">

                            </div>
                            <div class="col-3">
                                <a href=" javaScript:void(0);" id="saveasistencia" class="btn btn-block btn-primary btn-lg"><i class="fas fa-save"></i> Finalizar Partido</a>
                                <input id="url_domin" type="hidden" value="{{route('asistencias.show',$data['aperturapartidoid'])}}">
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('js_contenido')
<!-- SweetAlert2 -->
<script src="{{asset('backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('backend/plugins/toastr/toastr.min.js')}}"></script>
<!-- Page specific script -->
<script src="{{asset('js/asistencia/pagos.js')}}"></script>
<script>
    $(function () {
        var arbit = parseInt($('#arbitro').val())
        if(arbit >0)
            $('#precioArbitro').val($('.precios_'+arbit).val())

        var cancha = parseInt($('#cancha').val())
        if(cancha >0)
            $('#precioCancha').val($('.precioscancha_'+cancha).val())
    })
        
    $(document).on('click','#saveasistencia', function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        var _arbitroid = parseInt($('#arbitro').val())
        var _canchaid = parseInt($('#cancha').val())
        var _arbitroprecio = parseFloat($('#precioArbitro').val())
        var _canchaprecio = parseFloat($('#precioTotalc').val())
        var _canthoras = parseInt($('#cantidahora_').val())
        var cantidadjugadores = parseInt($('#tb_asistentes tbody tr td.correlativo').length)

        var montoapuesta = ((10*cantidadjugadores) - (_canchaid*(_arbitroprecio+_canchaprecio)))
        
        var entra = false
        var mensa = 'Error'
        var _ganadores = ($('.custom-control-input').is(':checked')) ? true : false

        if(cantidadjugadores>0)
        {
            if(_ganadores)
            {
                if(montoapuesta>0)
                {
                    if(_canthoras>0)
                    {
                        if(_arbitroprecio>0)
                        {
                            if(_canchaprecio>0)
                            {
                                entra = true
                                mensa = 'Valores Ok'
                            }
                            else
                            {
                                mensa = 'Error Pago Cancha'
                                $('#precioTotalc').focus() 
                            }
                        }
                        else
                        {
                            mensa = 'Error Pago Arbitro'
                            $('#_arbitroprecio').focus()
                        }
                    }
                    else
                    {
                        mensa = 'Ingresar las HORAS'
                        $('#cantidahora_').focus()
                    }
                }
                else
                {
                    mensa = 'No hay salgo para pagar Arbitro y Cancha'
                }
            }
            else
            {
                mensa = 'Selecionar Ganadores'
            }
        }
        else
        {
            mensa = 'Ingresar Jugadores'
        }
        

        if(entra)
        {           
            var $post = {};
            let _token   = $('meta[name="csrf-token"]').attr('content')
            $post._token = _token;
            $post._arbitroid = _arbitroid;
            $post._canchaid = _canchaid;
            $post._arbitroprecio = _arbitroprecio;
            $post._canchaprecio = _canchaprecio;
            $post._canthoras = _canthoras;
            $.ajax({
                url:'/asistencias/{{$data['aperturapartidoid']}}/saveterminarpartido',
                type:'POST',
                data:$post,
                beforeSend: function() {
                    //showLoader();
                    $('body').attr({'class':'hold-transition sidebar-mini layout-fixed','style':''})
                    $('body .preloader').attr({'style':''})
                    $('.animation__shake').attr({'style':''})
                },
                success:function (data) {
                    if(data.estado == 1)
                    {
                        Toast.fire({
                            icon: 'success',
                            title: data.mensaje
                        })
                        window.location.href = $('#url_domin').val()
                    }
                    else
                    {
                        $('body').attr({'class':'sidebar-mini layout-fixed','style':'height: auto;'})
                        $('body .preloader').attr({'style':'height: 0px;'})
                        $('.animation__shake').attr({'style':'display: none;'})
                    }                
                }
            })
        }
        else
        {
            Toast.fire({
                icon: 'error',
                title: mensa
            })
        }
    })

    $(document).on('click','.savefalta', function() {
        var tis = $(this)
        var pad = tis.parents('tr')
        
        var ida = parseInt(pad.attr('asistiopartido')) //asistio        
        var tip = parseInt(tis.attr('tipo'))           //Tipo de tarjeta

        var tar = tip == 2 ? "Roja" : "Amarilla"
        var nomb = tis.parents('tr').find('td.nombres').html()

        if(ida>0 && tip>0)
        {
            var $post = {};
            let _token   = $('meta[name="csrf-token"]').attr('content')
            $post._token = _token;
            $post._tipo = tip;

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            Swal.fire({
                title: '¿Le sacas la Tarjeta '+tar+'?',
                text: "Al jugador: "+nomb+" .!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, por Faltoso!'
            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        data: $post,
                        url: '/asistencias/'+ida+'/saveasistenciafalta',
                        success: function (response) {
                            if(response.estado == 1)
                            {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.mensaje
                                })
                                tis.find('.badge').html(response.cant)
                            }
                        }
                    });
                }
            })
        }
    })

    $(document).on('change','.custom-control-input', function() {
        var ida = parseInt($(this).parents('tr').attr('asistiopartido')) 
        var _check = $(this).is(':checked') ? 2 : 1
        var msn = _check == 1 ? "Es Ganador": "No Gano"
        var icon = 'error';
        if(ida >0)
        {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            
            var $post = {};
            let _token   = $('meta[name="csrf-token"]').attr('content')
            $post._token = _token;
            $post._ganador = _check;

            $.ajax({
                type: "POST",
                data: $post,
                url: '/asistencias/'+ida+'/saveasistenciagandor',
                success: function (response) {
                    if(response.estado)
                        icon = 'success'
                    else
                        tis.prop('checked', false);

                    Toast.fire({
                        icon: icon,
                        title: response.mensaje
                    })
                }
            });
        }
    })
</script>
@endsection