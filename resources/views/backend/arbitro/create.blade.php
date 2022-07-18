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
                    <h1>Agregar arbitros</h1>
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
                    <h3 class="card-title" style="display: inline">Lista de arbitros</h3>
                    <a href="{{route('arbitros.index')}}" class="btn btn-sm btn-default float-right"><i class="fas fa-reply-all"> Atrás</i></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb_arbitros" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Tipo</th>
                                    <th>Numero</th>
                                    <th>Precio</th>
                                    <th>Es Arbitro</th>
                                    <th>Agregar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($arbitros as $key=>$arbitro)
                                    <tr personaid="{{$arbitro['id']}}" id="tr_pers_{{$arbitro['id']}}">
                                        <td>{{$key+1}}</td>
                                        <td>{{$arbitro['nombres']}}</td>
                                        <td>{{$arbitro['apellidos']}}</td>
                                        <td>{{$arbitro['tipo_documentos']}}</td>
                                        <td>{{$arbitro['numero_documento']}}</td>
                                        <td class="precio">{{$arbitro['precio']}}</td>
                                        <td class="esarbitro">
                                            @if ($arbitro['estado'] === "Activo")
                                                Si
                                            @else
                                                No                                        
                                            @endif
                                        </td>
                                        <td class="addbtn">
                                            @if ($arbitro['estado'] != "Activo")
                                                <button type="button" class="btn btn-primary btn-sm addarbitro" data-toggle="modal" data-target="#add_arbitro">Agregar</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Tipo Documento</th>
                                    <th># Documento</th>
                                    <th>Precio</th>
                                    <th>Es Arbitro</th>
                                    <th>Agregar</th>
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

        $("#tb_arbitros").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            language: {url: "{{asset('backend/pages/tables/es.json')}}"},
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tb_arbitros_wrapper .col-md-6:eq(0)');
    });

    $(document).on('click','.addarbitro', function() {
        var tis = $(this).parents('tr')
        var personaid = tis.attr('personaid')
        $('#precio').val('')
        $('#persona_id').val(personaid)
    });

    $(document).on('click','.savearbitro', function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        let _token   = $('meta[name="csrf-token"]').attr('content')
        var precio = parseFloat($('#precio').val())
        var personaid = parseInt($('#persona_id').val())

        personaid = personaid > 0 ? personaid : 0
        precio = precio > 0 ? precio : 0
        
        if(personaid > 0 && precio>0)
        {   
            var $post = {};
            $post.precio = precio;
            $post.estado = 1;
            $post._token = _token;

            var padre = $('#tr_pers_'+personaid)

            $.ajax({
                type: "POST",
                data: $post,
                url: '/arbitros/'+personaid+'/savearbitros',
                success: function (response) {
                    if(response.estado == 1)
                    {
                        $('#add_arbitro').modal('hide')
                        padre.find('td.precio').html(precio)
                        padre.find('td.esarbitro').html('Si')
                        padre.find('td.addbtn').html('');
                        Toast.fire({
                            icon: 'success',
                            title: response.mensaje
                        })
                    }
                }
            });
        }
        else{
            Toast.fire({
                icon: 'error',
                title: "Agregar precio"
            })
        }
    });
</script>
@endsection