@extends('backend.layouts.app')
@section('css_contenido')
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{asset('backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('backend/plugins/toastr/toastr.min.css')}}">
 <!-- Tempusdominus Bootstrap 4 -->

 <link rel="stylesheet" type="text/css" href="https://www.goerp.pe/web/utilitarios/css/fecha/bootstrap-datetimepicker.css" />
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Apertura Fecha Partido</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="display: inline">Lista de Fechas</h3>
                @if(!empty($data['envapertura']))
                    @if(!empty($data['aperturarmes']))
                        <div class="btn-group float-right" anio="{{ $data['envapertura'] }}">
                            <button type="button" class="btn btn-default"><b>{{ $data['envapertura'] }}</b> puede Aperturar los meses</button>
                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                        @if(!empty($data['losmeses']))
                            @foreach($data['losmeses'] as $kk=>$vv)
                                @php
                                    $class = ($vv['mes'] == $data['aperturarmes']) ? true: false;
                                @endphp
                                <a mes="{{ $vv['mes'] }}" aperturamesid="{{ $kk }}" @class(["dropdown-item","diaapertura",'active'=>$class]) data-toggle="modal" data-target="#aperturapartido" href="javascript:void(0);">{{ $vv['mestext'] }}</a>
                            @endforeach
                        @endif
                            </div>
                        </div>
                    @else
                        <h3 class="card-title float-right">{{$data['envapertura']}} No aperturo el mes <b>{{$data['envapertura']}}</b></h3>
                    @endif
                @endif
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                @if(!empty($data['envapertura']))
                    @if(!empty($data['aperturarmes']))
                        <div class="table-responsive">
                            <table id="tb_aperturapartido" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Año</th>
                                    <th>Mes</th>
                                    <th>Fecha</th>
                                    <th>Monto recaudado</th>
                                    <th>Fondo para el club</th>
                                    <th>Monto apuesta</th>
                                    <th>Arbitro</th>
                                    <th>Pago arbitro</th>
                                    <th>Pago Cancha</th>
                                    <th># horas</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                        @if($data['partidoapertura'])
                            @foreach($data['partidoapertura'] as $ki=>$vv)
                                @php
                                    $str = strtotime($vv['fecha_partido']);
                                    $anio = date("Y",$str);
                                    $misx = (int) date("m",$str) ;
                                    $mes = getmes($misx);
                                    $fec = date("d-m-Y",$str);
                                @endphp
                                <tr>
                                    <td>{{ $ki+1 }}</td>
                                    <td>{{ $anio }}</td>
                                    <td>{{ $mes }}</td>
                                    <td>{{ $fec }}</td>
                                    <td class="text-right">
                                    @if(!empty($vv['monto_recaudado']))
                                        <em class="pull-left">S./</em>
                                        {{ $vv['monto_recaudado'] }}
                                    @endif
                                    </td>
                                    <td class="text-right">{{ $vv['monto_para_club'] }}</td>
                                    <td class="text-right">{{ $vv['monto_para_apuesta'] }}</td>
                                    <td>
                                    @if(!empty($data['arbitros'][$vv['arbitro_id']]))
                                        {{$data['arbitros'][$vv['arbitro_id']]}}
                                    @endif
                                    </td>
                                    <td class="text-right">{{ $vv['pago_arbitraje'] }}</td>
                                    <td>{{ $vv['pago_cancha'] }}</td>
                                    <td class="text-right">{{ $vv['cantidad_horas'] }}</td>
                                    <td>{{ $vv['estado'] }}</td>
                                    <td>
                                @switch ($vv['estado'])
                                    @case('Pendiente')
                                    <a href="{{route('registrarasistencia',$vv['id'])}}" class="btn btn-sm btn-info float-warning"><i class="fas fa-user-plus"></i> </a>
                                        @break
                                    @case('Jugando')
                                        <a href="{{route('registrarpartido',$vv['id'])}}" class="btn btn-sm btn-warning float-info"><i class="fas fa-running"></i> </a>
                                        @break                                    
                                    @case('Finalizo')
                                        <a href="{{route('asistencias.show',$vv['id'])}}" class="btn btn-sm btn-default"><i class="fas fa-eye" ></i> </a>
                                        @break
                                    @default
                                @endswitch                                        
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="13"><h1 class="text-center">No hay registros</h1></td></tr>
                        @endif
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Año</th>
                                    <th>Mes</th>
                                    <th>Fecha</th>
                                    <th>Monto recaudado</th>
                                    <th>Fondo para el club</th>
                                    <th>Monto apuesta</th>
                                    <th>Arbitro</th>
                                    <th>Pago arbitro</th>
                                    <th>Pago Cancha</th>
                                    <th># horas</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <h1 class="text-center">Aperturar Meses</h1>
                    @endif
                @else
                        <h1 class="text-center">Aperturar Año</h1>
                @endif
                    </div>
                    <!-- /.card-body -->
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

    <div class="modal fade" id="aperturapartido">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Aperturar Partido</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_aperturapartido">                        
                        <div class="form-group">
                            <label><b id="subtitulo"></b> Seleccionar Día:</label>
                            <input type="hidden" id="aperturarmes_id" name="aperturarmes_id"/>
                            <input type="hidden" id="fecha_inicio" name="fecha_inicio"/>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="input-prepend input-group" id='fecha_'>
                                            <input name="fecha_i" type="text" value="" class="form-control" id="fecha_i" placeholder="Fecha" aria-describedby="fecha_i">
                                            <span class="add-on input-group-addon input-group-append">
                                                <div class="input-group-text">
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                </div>                                                
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>                      
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary saveaperturarpartido">Agregar</button>
                    <input id="url_domin" type="hidden" value="{{route('registrarasistencia','idx')}}">
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
<!-- jQuery -->
<script src="https://www.goerp.pe/web/utilitarios/js/jquery.min.js"></script>
<!-- Fechas  & Plugins -->
<script type="text/javascript" src="https://www.goerp.pe/web/utilitarios/js/moment/moment.min.js"></script>
<script type="text/javascript" src="https://www.goerp.pe/web/utilitarios/js/fecha/es.js"></script>
<script type="text/javascript" src="https://www.goerp.pe/web/utilitarios/js/fecha/bootstrap-datetimepicker.js"></script>
<!-- SweetAlert2 -->
<script src="{{asset('backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('backend/plugins/toastr/toastr.min.js')}}"></script>
<!-- Page specific script -->
<script>
    $(function () {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('#fecha_').datetimepicker({
            format: 'DD-MM-YYYY',
            locale: moment.locale("es"),
            ignoreReadonly:false,
        });

        $(document).on('click','.diaapertura', function() {
            var tis = $(this)
            var pad = tis.parents('.btn-group')
            var anio = pad.attr('anio')
            var mes = tis.html()
            var fecha_inicio = tis.attr('mes')
            var aperturamesid = tis.attr('aperturamesid')
            $('#subtitulo').html(anio+' de '+mes)
            $('#aperturarmes_id').val(aperturamesid)
            $('#fecha_inicio').val(fecha_inicio)

            $('#fecha_').val('')
            $('#fecha_').data("DateTimePicker").minDate(false);
            $('#fecha_').data("DateTimePicker").maxDate(false);
            $('#fecha_').data("DateTimePicker").defaultDate(false)
            
            var fechai = moment(fecha_inicio)
            var fechaf = moment(fecha_inicio).endOf('month')
            
            $('#fecha_').data("DateTimePicker").minDate(new Date(fechai));
            $('#fecha_').data("DateTimePicker").maxDate(new Date(fechaf));

            let _token   = $('meta[name="csrf-token"]').attr('content')
            var aperturamesid = parseInt(aperturamesid)
            var disabled = []
            var troz = []
            var anix = 0
            var mesx = 0
            var diax = 0

            $('#fecha_').data("DateTimePicker").disabledDates(disabled)

            if(aperturamesid>0)
            {
                var $post = {};
                $post._token = _token;
                $post.fechai = moment(fechai).format("YYYY-MM-DD")
                $post.fechaf = moment(fechaf).format("YYYY-MM-DD")

                $.ajax({
                    type: "POST",
                    data: $post,
                    url: '/asistencias/'+aperturamesid+'/validaraperturarpartido',
                    success: function (response) {
                        if(response.estado == 1)
                        {
                            $.each(response.partidos, function(ky, fechx) {
                                troz = fechx.split('-')
                                anix = troz[0]
                                mesx = parseInt(troz[1])
                                diax = parseInt(troz[2])
                                disabled[ky] = new Date(anix, mesx - 1, diax)
                            });
                            $('#fecha_').data("DateTimePicker").disabledDates(disabled)
                            $('#fecha_').data("DateTimePicker").defaultDate(response.select)
                            if(response.select)
                                $('#fecha_').val((response.select))
                        }
                    }
                });
            }
        })

        $(document).on('click','.saveaperturarpartido', function() {
            var idmes = parseInt($('#aperturarmes_id').val())
            var fecha = $('#fecha_i').val()
            var esicon = 'error'
            if(idmes > 0)
            {
                if($.trim(fecha) != '')
                {
                    var $post = {};
                    $post._token = $('meta[name="csrf-token"]').attr('content');
                    $post._fechai = datetoing(fecha)

                    $.ajax({
                        type: "POST",
                        data: $post,
                        url: '/asistencias/'+idmes+'/saveaperturarpartido',
                        success: function (response) {
                            if(response.estado == 1)
                            {
                                esicon = 'success'
                                window.location.href = $('#url_domin').val().replace("idx", response.rta);
                            }
                            Toast.fire({
                                icon: esicon,
                                title: response.mensaje
                            })
                            
                        }
                    });
                }
                else
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Agregar Fecha'
                    })
                }
                    
            }
        })

        function datetoing(fec)
        {
            var fec = fec.split("-");
            var fe_in = new Date(fec[2], fec[1] - 1, fec[0]);
            return moment(fe_in).format("YYYY-MM-DD");
        }
    });

    

    
  </script>
@endsection