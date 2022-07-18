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
                    <h1>canchas</h1>
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
                        <h3 class="card-title" style="display: inline">Lista de Canchas</h3>
                        <button class="btn btn-sm btn-primary float-right nuevacancha" data-toggle="modal" data-target="#editar_cancha"><i class="fas fa-file"></i> Nueva Cancha</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb_cancha" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Celular</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($canchas as $key=>$cancha)
                                    <tr canchaid="{{$cancha['id']}}" id="tr_{{$cancha['id']}}">
                                        <td>{{$key+1}}</td>
                                        <td class="tdnombres">{{$cancha['cancha']}}</td>
                                        <td class="tdceulular">{{$cancha['celular']}}</td>
                                        <td class="tdprecio">{{$cancha['precio']}}</td>
                                        <td class="tdestado">{{$cancha['estado']}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-warning editarcancha" data-toggle="modal" data-target="#editar_cancha"><i class="fas fa-edit"></i></button>
                                        <td class="text-center">
                                        @if($cancha['estado']=="Activo")
                                            <button class="btn btn-sm btn-danger eliminar" type="button"><i class="fas fa-trash-restore-alt"></i></button>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Celular</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
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

    <div class="modal fade" id="editar_cancha">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Mantenimiento Cancha</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary" id="cont_cobranza">
                        <div class="card-header">
                            <h3 class="card-title">Registrar</h3>
                        </div>
                        <div class="card-body">
                            <form id="edit_cancha">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="form-group row">
                                            <label for="staticcancha" class="col-sm-5 col-form-label">Cancha</label>
                                            <div class="col-sm-7"><input type="text" name="cancha" class="form-control" id="staticcancha"></div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticcelular" class="col-sm-5 col-form-label">Celular</label>
                                            <div class="col-sm-7"><input type="text" name="celular" class="form-control" id="staticcelular"></div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticFecha" class="col-sm-5 col-form-label">Precio</label>
                                            <div class="col-sm-7">
                                                <div class="input-group mb-3" style="margin-bottom: 0 !important;">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">S/.</span>
                                                    </div>
                                                    <input type="number" min="1" max="99" id="precio" class="form-control" aria-label="Amount (to the nearest pen)">
                                                    <div class="input-group-append">
                                                        <span id="elmax" class="input-group-text">xHora</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <button type="button" class="btn btn-primary btn-block savecancha">Guardar</button>
                                        <input type="hidden" value="" name="cancha_id" id="cancha_id">
                                    </div>
                                </div>                                                                              
                            </form>
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

        $("#tb_cancha").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            language: {url: "{{asset('backend/pages/tables/es.json')}}"},
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tb_cancha_wrapper .col-md-6:eq(0)');
    });

    function limpiar(titulo,boton)
    {
        $('#cancha_id').val('')
        $('#precio').val('')
        $('#staticcelular').val('')
        $('#staticcancha').val('')
        $('#editar_cancha h3.card-title').html(titulo)
        $('.savecancha').html(boton)
    }

    $(document).on('click','.nuevacancha', function() {
        limpiar('Registrar','Guardar')
    })

    $(document).on('click','.editarcancha', function() {
        limpiar('Editar','Actualizar')
        var pad = $(this).parents('tr')  
        
        $('#cancha_id').val(pad.attr('canchaid'))
        $('#precio').val(parseFloat(pad.find('.tdprecio').html()))
        $('#staticcelular').val(pad.find('.tdceulular').html())
        $('#staticcancha').val(pad.find('.tdnombres').html())
    })

    $(document).on('click','.savecancha', function() {
        savecancha()
    })

    function savecancha()
    {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        var precio = parseFloat($('#precio').val())
        var _cancha = $('#staticcancha').val()
        if($.trim(_cancha) != '' && _cancha.length)
        {
            if(precio >0)
            {
                var _canchaid = $('#cancha_id').val()
                var $post = {};
                $post._token = $('meta[name="csrf-token"]').attr('content');
                $post._precio = precio
                $post._cancha = _cancha
                $post._canchaid = _canchaid
                $post._celular= $('#staticcelular').val()

                $.ajax({
                    type: "POST",
                    data: $post,
                    url: '/canchas/',
                    success: function (response) {
                        var err = (response.estado == 1) ? "success" : "error"

                        Toast.fire({
                            icon: err,
                            title: response.mensaje
                        })

                        if(response.estado)
                            window.location.reload();
                    }
                });
            }
            else
            {
                Toast.fire({
                    icon: 'error',
                    title: 'Ingresar Precio'
                })
                $('#precio').focus()
            }
        }
        else
        {
            Toast.fire({
                icon: 'error',
                title: 'Ingresar Cancha'
            })
            $('#staticcancha').focus()
        }        
    }

    $(document).on('click','.eliminar', function() {
        var tis = $(this)
        var pad = tis.parents('tr')
        var _canchaid = parseInt(pad.attr('canchaid'))
        if(_canchaid >0)
        {
            Swal.fire({
                title: '¿Esta seguro de ELIMINAR?',
                text: "No podrás revertir esto.!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: '/canchas/'+_canchaid,
                        success: function (response) {
                            if(response.estado == 1)
                            {
                                Swal.fire(
                                    'Elimino!',
                                    'El socio fue eliminado.',
                                    'success'
                                )
                                pad.find('.tdestado').html('Cancelado')
                                tis.remove()
                            }
                        }
                    });
                }
            })
        }
    })

  </script>
@endsection