@extends('backend.layouts.app')
@section('css_contenido')
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<style>
    .color-palette {
      height: 35px;
      line-height: 35px;
      text-align: right;
      padding-right: .75rem;
    }

    .color-palette.disabled {
      text-align: center;
      padding-right: 0;
      display: block;
    }

    .color-palette-set {
      margin-bottom: 15px;
    }

    .color-palette span {
      display: none;
      font-size: 12px;
    }

    .color-palette:hover span {
      display: block;
    }

    .color-palette.disabled span {
      display: block;
      text-align: left;
      padding-left: .75rem;
    }

    .color-palette-box h4 {
      position: absolute;
      left: 1.25rem;
      margin-top: .75rem;
      color: rgba(255, 255, 255, 0.8);
      font-size: 12px;
      display: block;
      z-index: 7;
    }
  </style>
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
                    <h1>Aperturar Mes</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
                <div class="card card-default color-palette-box">
                    <div class="card-header">
                        <h3 class="card-title" style="display: inline">Lista de Aperturas</h3>
                    @if(!empty($envapertura))
                        <h3 class="card-title float-right">Aun no Aperturo el año <b>{{$envapertura}}</b></h3>
                    @else
                        @if($mes == 0)
                            <h3 class="card-title float-right">El mes: <b>{{$nom}}</b> está Aperturado</h3>
                        @else
                            <button class="btn btn-sm btn-primary float-right saveaperturarmes"><i class="fas fa-calendar"></i> Aperturar mes: <b>{{$nom}}</b></button>
                        @endif
                    @endif
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    @if(!empty($envapertura))
                        <h1 class="text-center">Aperturar Año</h1><a href="{{route('aperturaranios.index')}}" class="btn btn-sm btn-primary float-right saveaperturaranios"><i class="fas fa-calendar"></i> Ir Aperturar Año</a>                       
                    @else
                        @if(!empty($aperturarmes))
                            @php
                                $mess = array("xxx","primary","secondary","info","success","warning","danger","black","gray","indigo","lightblue","fuchsia","orange");
                                $clas = "";
                            @endphp
                            <div class="row">
                            @foreach ($aperturarmes as $key=>$mesapertura)
                                @php
                                    $clas = isset($mess[($key+1)]) ? $mess[($key+1)] : "primary";
                                @endphp
                                <div class="col-sm-4 col-md-2">
                                    <h4 class="text-center bg-{{$clas}}">{{$mesapertura}} </h4>
                                    <div class="color-palette-set">
                                        <div class="bg-{{$clas}} color-palette"><span></span></div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        @else
                            <h1 class="text-center">No existen registros apertura de Mes</h1>
                        @endif
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

    <input type="hidden" value="{{route('socios.create')}}" name="url_domin" id="url_domin">
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
    });

    $(document).on('click','.saveaperturarmes', function() {
        Swal.fire({
            title: 'Aperturar Mes',
            text: "¿Esta seguro de Aperturar este Mes?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Seguro!'
        }).then((result) => {
            if (result.isConfirmed)
            {
                var $post = {};
                $post._token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: "POST",
                    data: $post,
                    url: '/aperturarmes/1/saveaperturarmes',
                    success: function (response) {
                        if(response.estado > 0)
                        {
                            Swal.fire(
                                'OK!',
                                'Guardo ok.',
                                'success'
                            )
                            //window.location.href = $('#url_domin').val()
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });
    
  </script>
@endsection