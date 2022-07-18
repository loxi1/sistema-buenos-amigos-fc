@extends('backend.layouts.app')
@section('css_contenido')
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Personas</h1>
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
                    <h3 class="card-title" style="display: inline">Lista de Personas</h3>
                    <a href="{{route('personas.create')}}" class="btn btn-sm btn-primary float-right"><i class="fas fa-file"></i> Nuevo</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb_persona" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>sexo</th>
                                    <th>Tipo</th>
                                    <th>Documento</th>
                                    <th>fecha_nacimiento</th>
                                    <th>celular</th>
                                    <th>Departamento</th>
                                    <th>Provincia</th>
                                    <th>Distrito</th>
                                    <th>Dirección</th>
                                    <th>Referencia</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($personas as $key=>$persona)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$persona['nombres']}}</td>
                                        <td>{{$persona['apellidos']}}</td>
                                        <td>{{$persona['sexo']}}</td>
                                        <td>{{$persona['tipo_documentos_id']}}</td>
                                        <td>{{$persona['numero_documento']}}</td>
                                        <td>{{$persona['fecha_nacimiento']}}</td>
                                        <td>{{$persona['celular']}}</td>
                                        <td>{{$persona['departamentos']}}</td>
                                        <td>{{$persona['provincias']}}</td>
                                        <td>{{$persona['distritos']}}</td>
                                        <td>{{$persona['direccion']}}</td>
                                        <td>{{$persona['referencia']}}</td>
                                        <td class="text-center">
                                            <a href="{{route('personas.edit',$persona['id'])}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a></td>
                                        <td class="text-center">
                                            <form class="text-center" action="{{route('personas.destroy',$persona['id'])}}" method="POST">
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
                                    <th>sexo</th>
                                    <th>Tipo</th>
                                    <th>Documento</th>
                                    <th>fecha_nacimiento</th>
                                    <th>celular</th>
                                    <th>Departamento</th>
                                    <th>Provincia</th>
                                    <th>Distrito</th>
                                    <th>Dirección</th>
                                    <th>Referencia</th>
                                    <th></th>
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
    </div>
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
<script src="{{asset('js/persona/ubigeo.js')}}"></script>
<!-- Page specific script -->
<script>
    $(function () {
        // $("#tb_persona").DataTable({
        // "responsive": true, "lengthChange": false, "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        // language:{
        //     url: "{{asset('backend/pages/tables/es.json')}}"
        // }
        // }).buttons().container().appendTo('#tb_persona_wrapper .col-md-6:eq(0)');
        $("#tb_persona").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            language: {url: "{{asset('backend/pages/tables/es.json')}}"},
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tb_persona_wrapper .col-md-6:eq(0)');
    
    });
  </script>
@endsection