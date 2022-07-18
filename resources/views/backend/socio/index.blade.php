@extends('backend.layouts.app')
@section('css_contenido')
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{asset('backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('backend/plugins/toastr/toastr.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Socios Activos</h1>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="display: inline">Lista de Socios
                            @if(!empty($aperturaranio['anio']))
                             Para el año <b>{{ $aperturaranio['anio'] }}</b>
                            @endif
                        </h3>
                    @if(!empty($aperturaranio['id']))
                        <a href="{{route('socios.create')}}" class="btn btn-sm btn-primary float-right"><i class="fas fa-file"></i> Nuevo Socio</a>
                    @else
                    <a href="{{route('aperturaranios.index')}}" class="btn btn-sm btn-primary float-right"><i class="fas fa-calendar"></i> &nbsp;Aperturar Año</a>
                    @endif
                        
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(!empty($aperturaranio['id']))
                            <div class="table-responsive">
                                <table id="tb_socio" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Tipo Socio</th>
                                        <th>Monto Inscripción</th>
                                        <th>Celular</th>
                                        <th>Año</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($socios as $key=>$persona)
                                        <tr socioid="{{$persona['id']}}" id="tr_{{$persona['id']}}">
                                            <td>{{$key+1}}</td>
                                            <td class="tdnombres">{{$persona['nombres']}}</td>
                                            <td class="tdapellidos">{{$persona['apellidos']}}</td>
                                            <td class="tdtiposocio" tipsocio="{{$persona['tiposocios_id']}}">{{$persona['tipo_socios']}}</td>
                                            <td class="tdprecio">{{$persona['precio']}}</td>
                                            <td>{{$persona['celular']}}</td>
                                            <td>{{$persona['anio']}}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-warning versocio" data-toggle="modal" data-target="#editar_socio"><i class="fas fa-edit"></i></button>
                                            <td class="text-center">
                                                <form class="text-center" action="{{route('socios.destroy',$persona['id'])}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger" type="submit"><i class="fas fa-trash-restore-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Tipo Socio</th>
                                        <th>Monto Inscripción</th>
                                        <th>Celular</th>
                                        <th>Anio</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <h1 class="text-center">Tiene que aperturar un año</h1>
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

    <div class="modal fade" id="editar_socio">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Socio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_socio">
                        <div class="form-group row">
                            <label for="nombreCompleto" class="col-sm-4 col-form-label">Nombre Completo</label>
                            <div class="col-sm-6">
                                <input id="nombreCompleto" type="text" readonly class="form-control-plaintext" value="">
                                <input type="hidden" value="" name="id" id="socio_id">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tiposocios_id" class="col-sm-4 col-form-label">Tipo de Socio</label>
                            <div class="col-sm-6">
                                {!! Form::select('tiposocios_id',$tiposocios,'',['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="precio" class="col-sm-4 col-form-label">Precio</label>
                            <div class="col-sm-6">
                                <input id="precio" type="text" readonly class="form-control-plaintext" value="">
                            </div>
                        </div>
                    </form>
                    @foreach ($precios as $ki=>$precio)
                        <input type="hidden" class="precio_{{$ki}}" value="{{$precio}}">
                    @endforeach
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary editarsocio">Editar</button>
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
<script src="{{asset('js/socio/socio.js')}}"></script>
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

        $("#tb_socio").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            language: {url: "{{asset('backend/pages/tables/es.json')}}"},
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tb_socio_wrapper .col-md-6:eq(0)');
    });
  </script>
@endsection