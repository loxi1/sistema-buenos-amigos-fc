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
<link rel="stylesheet" href="{{asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<script src="{{asset('js/cobranza/cobranza.js')}}"></script>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cuentas x cobrar Inscipción</h1>
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
                        <h3 class="card-title" style="display: inline">Listado de cuentas</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb_cobranzas" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres completo</th>
                                    <th>Documento</th>
                                    <th>Año</th>
                                    <th>Monto x Cobrar</th>
                                    <th>Monto Cobrado</th>
                                    <th>Monto Pendiente</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cuentasxcobrar as $key=>$cobrar)
                                    <tr cuentasxcobrarinscripcionid="{{$cobrar['id']}}" id="tr_{{$cobrar['id']}}">
                                        <td>{{$key+1}}</td>
                                        <td class="nombrecompleto">{{$cobrar['nombres']}}, {{$cobrar['apellidos']}}</td>
                                        <td>{{$cobrar['tipo_documentos']}} :  {{$cobrar['numero_documento']}}</td>
                                        <td>{{$cobrar['anio']}}</td>
                                        <td class="montocobrar">{{$cobrar['monto_cobrar']}}</td>
                                        <td class="mcobrado">{{$cobrar['monto_cobrado']}}</td>
                                        <td class="mpendiente">{{$cobrar['monto_pendiente']}}</td>
                                        <td class="estadocobros">{{$cobrar['estadocobros']}}</td>
                                        <td class="btncobranza">
                                        @if ($cobrar['cobranzaestados_id']<=2)   
                                            <button tipo="a" type="button" class="btn btn-sm btn-warning vercuentaxcobrar" data-toggle="modal" data-target="#pagarcuentas"><i class="fas fa-dollar-sign"></i> Cobrar</button>
                                        @elseif ($cobrar['cobranzaestados_id'] == 4)
                                            <button tipo="b" type="button" class="btn btn-sm btn-info vercuentaxcobrar" data-toggle="modal" data-target="#pagarcuentas"><i class="fas fa-eye"></i> Ver</button>                                        
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres completo</th>
                                    <th>Documento</th>
                                    <th>Año</th>
                                    <th>Monto x Cobrar</th>
                                    <th>Monto Cobrado</th>
                                    <th>Monto Pendiente</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    
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

    <div class="modal fade" id="pagarcuentas">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b id="titulomodal">Cobrar</b> Inscripción</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary" id="cont_cobranza">
                        <div class="card-header">
                            <h3 class="card-title">Registrar Cobranza</h3>
                        </div>
                        <div class="card-body" style="padding: 0.25rem 1.25rem 0.25rem 1.25rem;">
                            <form id="edit_cuentasxcobrarinscripcion">
                                <div class="row d-none" id="formulariopagar">
                                    <div class="col-9">
                                        <div class="form-group row">
                                            <label for="staticFecha" class="col-sm-5 col-form-label">Fecha Ingreso</label>
                                            <div class="col-sm-7">
                                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate">
                                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticFecha" class="col-sm-5 col-form-label">Monto a Cobrar</label>
                                            <div class="col-sm-7">
                                                <div class="input-group mb-3" style="margin-bottom: 0 !important;">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">1</span>
                                                    </div>
                                                    <input type="number" min="1" max="35" id="monto_pagar" class="form-control" aria-label="Amount (to the nearest pen)">
                                                    <div class="input-group-append">
                                                        <span id="elmax" class="input-group-text">35</span>
                                                    </div>
                                                </div>
                                                <input type="hidden" value="" name="cuentasxcobrarinscripcion_id" id="cuentasxcobrarinscripcion_id">
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <button type="button" class="btn btn-primary btn-block savecuentaxcobrar">Cobrar</button>
                                        <input type="hidden" value="" id="idcuentaxcob">
                                    </div>
                                </div>                                                                              
                            </form>
                            <h3 id="secobrotxt" class="text-center d-none">Se cobro la Inscripción</h3>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped" id="tabla_cobros">
                                <thead>
                                    <tr>
                                        <th colspan="2" id="elnombrecomp" class="text-center"></th>
                                    </tr>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('backend/plugins/moment/moment.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('js/cobranza/cobranza.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('backend/plugins/toastr/toastr.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{asset('backend/plugins/tempusdominus-bootstrap-4/js/es.js')}}"></script>
<!-- Page specific script -->
<script>
    $("#tb_cobranzas").DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        language: {url: "{{asset('backend/pages/tables/es.json')}}"},
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tb_cobranzas_wrapper .col-md-6:eq(0)');
</script>
@endsection