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
    /*the container must be positioned relative:*/
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff; 
        border-bottom: 1px solid #d4d4d4; 
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9; 
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important; 
        color: #ffffff; 
    }
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
                <div class="col-sm-3">
                    <h1>Registro de Asistencia</h1>
                </div>
                <div class="col-sm-9">
                    <input aperid="{{$data['aperturapartidoid']}}" name="buscarsocio" id="buscarsocio" class="form-control form-control-lg"/>
                    <div id="product_list" class="autocomplete-items"></div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                @if (session('mensaje'))
                <div class="alert alert-success">
                    <div class="alert alert-success">
                        <strong>{{session('mensaje')}}</strong>
                    </div>
                </div>
                @endif
                @php
                    $fechapartido = !empty($data['partidos']['fecha_partido']) ? $data['partidos']['fecha_partido'] : "";
                @endphp
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title" style="display: inline">Socios Presentes: <em><b style="font-size: 20px;">{{$fechapartido}}</b></em></h3>
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
                                    <th>Deuda Inscripción</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                    @if(!empty($data['asistio']))
                        @foreach($data['asistio'] as $kk=>$vv)
                            @php
                                //Amarillo = 1 bg-warning
                                $clasamari = (!empty($data['tarjetas'][$vv['socios_id']][1])) ? $data['tarjetas'][$vv['socios_id']][1] : false;

                                //Rojo = 2 bg-danger
                                $clasrojo = (!empty($data['tarjetas'][$vv['socios_id']][2])) ? $data['tarjetas'][$vv['socios_id']][2] : false;
                                
                                $deuda = (!empty($data['inscripciones'][$vv['socios_id']])) ? $data['inscripciones'][$vv['socios_id']] : 0;
                                $esdeuda = ($deuda == 0) ? false : true;
                            @endphp
                            <tr>
                                <td class="correlativo">{{ $kk+1 }}</td>
                                <td>{{ $vv['apellidos'].", ".$vv['nombres'] }}</td>
                                <td class="text-center">
                            @if($clasamari)
                                <a class="btn btn-app bg-warning"><span class="badge bg-info">{{$clasamari}}</span><i class="fas fa-bullhorn"></i></a>
                            @endif
                                </td>
                                <td class="text-center">
                            @if($clasrojo)
                                <a class="btn btn-app bg-danger"><span class="badge bg-info">{{$clasrojo}}</span><i class="fas fa-bullhorn"></i></a>
                            @endif
                                </td>
                                <td @class(['text-right','bg-danger'=>$esdeuda])>
                                    @if($esdeuda)
                                        <em>S/. </em>
                                    @endif
                                    {{$deuda}}
                                </td>
                                <td>
                                    <a href="{{route('eliminarasistencia',$vv['id'])}}" class="btn btn-block btn-light btn-xs"><i class="fas fa-times"></i></a>
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
                                    <th>Deuda Inscripción</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>                        
                    </div>
                    <!-- /.card-body -->
                </div>
               <!-- /.card -->
                @php
                    $id_arb = !empty($data['partidos']['arbitro_id']) ? $data['partidos']['arbitro_id'] : "";
                    $pa_arb = !empty($data['partidos']['pago_arbitraje']) ? $data['partidos']['pago_arbitraje'] : "";
                    $ca_hor = !empty($data['partidos']['cantidad_horas']) ? $data['partidos']['cantidad_horas'] : "";
                @endphp
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="display: inline">Asistencia</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">
                            <form>
                                <div class="row d-none">
                                    <div class="col-5">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                {!! Form::label('arbitro','Arbitro',['for'=>'inputArbitro'])  !!}
                                                {!! Form::select('arbitro',$data['arbitros'],$id_arb,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="precioArbitro">Precio</label>
                                                <input type="number" readonly="" class="form-control" id="precioArbitro" placeholder="">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="precioTotal">Total</label>
                                                <input value="{{$pa_arb}}" type="number" readonly="" class="form-control" id="precioTotal" placeholder="0.00">
                                            </div>
                                        </div>
                                        @foreach ($data['precios'] as $ki=>$precio)
                                            <input type="hidden" class="precios_{{$ki}}" value="{{$precio}}">
                                        @endforeach
                                    </div>
                                    <div class="col-2">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="cantidahora_">Horas</label>
                                                <input type="number" class="form-control" value="{{$ca_hor}}" id="cantidahora_" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputCancha">Cancha</label>
                                                <select id="inputCancha" class="form-control">
                                                    <option selected>Choose...</option>
                                                    <option>...</option>
                                                </select>
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
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-9">

                            </div>
                            <div class="col-3">
                                <a href=" javaScript:void(0);" id="saveasistencia" class="btn btn-block btn-primary btn-lg"><i class="fas fa-save"></i> Guardar Asistencia</a>
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

    <div class="modal fade" id="add_arbitro">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Precio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_arbitro">
                        <div class="form-group row">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">S/.</span>
                                </div>
                                <input placeholder="0.00" min="1" name="precio" type="number" id="precio" class="form-control" aria-label="Amount (to the nearest pen)">
                                <div class="input-group-append">
                                    <span class="input-group-text">x Hora</span>
                                </div>
                            </div>
                            <input type="hidden" value="" name="persona_id" id="persona_id">
                        </div>                        
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary savearbitro">Guardar</button>
                    <input id="url_domin" type="hidden" value="{{route('registrarpartido',$data['aperturapartidoid'])}}">
                    <input id="url_eliminar" type="hidden" value="{{route('eliminarasistencia','idx')}}">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
@endsection
@section('js_contenido')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<!-- SweetAlert2 -->
<script src="{{asset('backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('backend/plugins/toastr/toastr.min.js')}}"></script>
<!-- Page specific script -->
<script>
    
    $(function () {
        var arbit = parseInt($('#arbitro').val())
        console.log(arbit)
        if(arbit >0)
            $('#precioArbitro').val($('.precios_'+arbit).val())
    })

    $(document).on('click', 'li', function(){
        var tis = $(this)
        var value = tis.text();
        var id = tis.attr('sociosid')
        var aperid = parseInt($('#buscarsocio').attr('aperid'))
        var html = ''
        console.log('id_socios->'+id+' aperturames->'+aperid)
        if(aperid>0 && id>0)
        {
            var cantregistro = parseInt($('#tb_asistentes tbody tr td.correlativo').length)
            cantregistro = cantregistro > 0 ? cantregistro : 0
            var $post = {};
            let _token   = $('meta[name="csrf-token"]').attr('content')
            $post._token = _token;
            $post._idsocio = id;

            $.ajax({
                url:'/asistencias/'+aperid+'/saveasistenciasocio',
                type:'POST',
                beforeSend: function() {
                    //showLoader();
                    $('body').attr({'class':'hold-transition sidebar-mini layout-fixed','style':''})
                    $('body .preloader').attr({'style':''})
                    $('.animation__shake').attr({'style':''})
                },
                data:$post,
                success:function (data) {
                    if(data.estado == 1)
                    {
                        var rta = data.rta
                        cantregistro++
                        var deuda = (rta.deuda !='-') ? '<em>S/. </em> '+rta.deuda : ''
                        var clasdeu = (rta.deuda !='-') ? ' bg-danger' : ''
                        var url = $('#url_eliminar').val().replace("idx", rta.asisid)
                        var btna = (parseInt(rta.t_amar) > 0) ? '<a class="btn btn-app bg-warning"><span class="badge bg-info">'+rta.t_amar+'</span><i class="fas fa-bullhorn"></i></a></td>' : ''
                        var btnr = (parseInt(rta.t_roja) > 0) ? '<a class="btn btn-app bg-danger"><span class="badge bg-info">'+rta.t_roja+'</span><i class="fas fa-bullhorn"></i></a></td>' : ''
                

                        html = '<tr><td class="correlativo">'+cantregistro+'</td><td>'+rta.nombre+'</td>'+
                                '<td class="text-center">'+btna+'</td>'+
                                '<td class="text-center">'+btnr+'</td>'+
                                '<td class="text-right'+clasdeu+'">'+deuda+'</td>'+
                                '<td><a href="'+url+'" class="btn btn-block btn-light btn-xs"><i class="fas fa-times"></i></a></td>'
                                '</tr>'

                        if(cantregistro > 1)
                            $('#tb_asistentes tbody').append(html)
                        else
                            $('#tb_asistentes tbody').html(html)
                    }
                },
                complete: function() {
                    //hideLoader();
                    $('body').attr({'class':'sidebar-mini layout-fixed','style':'height: auto;'})
                    $('body .preloader').attr({'style':'height: 0px;'})
                    $('.animation__shake').attr({'style':'display: none;'})
                }
            })
        }
        $('#buscarsocio').val(value);
        $('#socio'+id).remove();
    });

    $(document).on('keyup','#buscarsocio', function() {
        var $post = {};
        let _token   = $('meta[name="csrf-token"]').attr('content')
        $post._token = _token;
        $post._query = $(this).val();
        $.ajax({
            url:'/asistencias/{{$data['aperturapartidoid']}}/asistenciasocio',
            type:'POST',
            data:$post,
                success:function (data) {
                $('#product_list').html(data.output);
            }
        })
    })
    
    $(document).on('click','#saveasistencia', function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        if($('#tb_asistentes tbody tr td.correlativo').length)
        {
            var $post = {};
            let _token   = $('meta[name="csrf-token"]').attr('content')
            $post._token = _token;
            $post._arbitroid = $('#arbitro').val();
            $post._arbitroprecio = $('#precioArbitro').val();
            $post._canthoras = $('#cantidahora_').val();
            $.ajax({
                url:'/asistencias/{{$data['aperturapartidoid']}}/saveasistencia',
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
                title: "Agregar socios"
            })
        }
    })

    $(document).on('change','#arbitro', function() {
        var arbit = parseInt($(this).val())
        
        if(arbit >0)
        {
            $('#precioArbitro').val($('.precios_'+arbit).val())
            var canth = parseFloat($(this).val())
            var preci = parseFloat($('#precioArbitro').val())

            if(preci>0 && canth>0)          
                $('#precioTotal').val(canth*preci)
        }
    });

    $(document).on('focusout','#cantidahora_', function() {
        var canth = parseFloat($(this).val())
        var preci = parseFloat($('#precioArbitro').val())
        if(canth >0)
        {
            if(preci>0)
                $('#precioTotal').val(canth*preci)                
        }
    });
</script>
@endsection