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
                <div class="col-sm-3">
                    <h1>Lista Asistencia</h1>
                </div>
                <div class="col-sm-9">
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
                    $suma = 0;
                    $sumr = 0;
                    $sumg = 0;
                @endphp
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title" style="display: inline">Lita de Jugadores <em><b style="font-size: 20px;">{{$fechapartido}}</b></em></h3>
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
                                
                                $cant = !empty($data['tarjetas'][$vv['id']][1]) ? $data['tarjetas'][$vv['id']][1] : 0;
                                $suma +=$cant;
                                $cant_a = ($cant) ? $cant : '';

                                $cant= !empty($data['tarjetas'][$vv['id']][2]) ? $data['tarjetas'][$vv['id']][2] : 0;
                                $sumr +=$cant;
                                $cant_r = ($cant) ? $cant : '';
                                if($vv['es_ganador']=='Si')
                                    $sumg++;

                            @endphp        
                                    {{$cant_a}}
                                </td>
                                <td class="text-center">
                                    {{$cant_r}}
                                </td>
                                <td class="text-center">
                                    @if($vv['es_ganador']=='Si') {{$vv['es_ganador']}} @endif
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
               @php
                    $esarbitro = !empty($data['partidos']['arbitro_id']) ? $data['partidos']['arbitro_id'] : '';
                    $escancha = !empty($data['partidos']['cancha_id']) ? $data['partidos']['cancha_id'] : '';
                    
                    $montoarbitro = !empty($data['partidos']['pago_arbitraje']) ? $data['partidos']['pago_arbitraje'] : '';
                    $montocancha = !empty($data['partidos']['pago_cancha']) ? $data['partidos']['pago_cancha'] : '';
                    $montoapuesta = !empty($data['partidos']['monto_para_apuesta']) ? $data['partidos']['monto_para_apuesta'] : '';
                    $montoaclub = !empty($data['partidos']['monto_para_club']) ? $data['partidos']['monto_para_club'] : '';
                    $montototal = !empty($data['partidos']['monto_recaudado']) ? $data['partidos']['monto_recaudado'] : '';
                    $canthoras = !empty($data['partidos']['cantidad_horas']) ? $data['partidos']['cantidad_horas'] : '';
                    $arbitr_o = !empty($data['arbitros'][$esarbitro]) ? $data['arbitros'][$esarbitro] : '';
                    $canch_a = !empty($data['canchas'][$escancha]) ? $data['canchas'][$escancha] : '';
                @endphp
                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-globe"></i> Club Buenos Amigos FC.
                                <small class="float-right">Fecha: {{$fechapartido}}</small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-3 invoice-col">
                            Total de horas
                            <address>
                                <strong>{{$canthoras}}</strong>
                            </address>
                        </div>
                        <div class="col-sm-3 invoice-col">
                            Tarjetas amrillas
                            <address>
                                <strong>{{$suma}}</strong>
                            </address>
                        </div>
                        <div class="col-sm-3 invoice-col">
                            Tarjetas rojas
                            <address>
                                <strong>{{$sumr}}</strong>
                            </address>
                        </div>
                        <div class="col-sm-3 invoice-col">
                            Total Ganadores
                            <address>
                                <strong>{{$sumg}}</strong>
                            </address>
                        </div>
                    </div>
                    <!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Servicio</th>
                                        <th>Descripción</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Arbitraje</td>
                                        <td>El sr. {{$arbitr_o}}</td>
                                        <td>S./ {{$montoarbitro}}</td>
                                    </tr>
                                    <tr>
                                        <td>Cancha</td>
                                        <td>La cancha:. {{$canch_a}}</td>
                                        <td>S./ {{$montocancha}}</td>
                                    </tr>
                                    <tr>
                                        <td>Apuesta</td>
                                        <td>Total acumulado por los asistentes</td>
                                        <td>S./ {{$montoapuesta}}</td>
                                    </tr>
                                    <tr>
                                        <td>Recaudación club</td>
                                        <td>Fondos para el club</td>
                                        <td>S./ {{$montoaclub}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-6"></div>
                        <!-- col -->
                        <div class="col-6">
                            <p class="lead">Importe Acumulado {{$fechapartido}}</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%">Total:</th>
                                            <td>S/. {{$montototal}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.invoice -->
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
@endsection