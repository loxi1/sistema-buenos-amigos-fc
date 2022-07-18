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
                    <h1>Aperturar Año</h1>
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
                        <h3 class="card-title" style="display: inline">Lista de Aperturas</h3>
                    @if(!empty($envapertura))
                        <button class="btn btn-sm btn-primary float-right saveaperturaranios"><i class="fas fa-file"></i> Aperturar Año {{ $envapertura }}</button>
                    @else
                        <h3 class="card-title float-right">El Año Aperturardo es: <b><?php echo date("Y");?></b></h3>
                    @endif
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    @if(!empty($aperturaranios[0]))
                        <div class="row">
                    @php
                        $axu = 0;
                        $cla = [];
                    @endphp
                    
                        @foreach ($aperturaranios as $key=>$aperturaranio)
                            @php
                                $aux = ((($key+1)%4) == 0) ? 4 : ((($key+1)%4));
                                $cla = $estilo[$aux];
                            @endphp
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-{{$cla['class']}}">
                                    <div class="inner">
                                        <h3>{{ $aperturaranio->anio }}</h3>
                                        <p><b>{{ $aperturaranio->cantidad }}</b> Socios</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-{{$cla['icon']}}"></i>
                                    </div>
                                    @if($aperturaranio->cantidad >0)
                                        <a href="{{route('aperturaranios.show',$aperturaranio->id)}}" class="small-box-footer"> Ver Socios <i class="fas fa-arrow-circle-right"></i></a>
                                    @else
                                        <a href="{{route('socios.index')}}" class="small-box-footer"> Agregar Socios <i class="fas fa-arrow-circle-right"></i></a>
                                    @endif
                                </div>
                            </div>
                        @endforeach                       
                        </div>
                        
                    @else
                        <h1 class="text-center">No existen registros</h1>
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
    
    $(document).on('click','.saveaperturaranios', function() {
        Swal.fire({
            title: 'Aperturar Año',
            text: "¿Esta seguro de Aperturar este Año?",
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
                    url: '/aperturaranios/1/saveaperturaranios',
                    success: function (response) {
                        if(response.estado == 1)
                        {
                            Swal.fire(
                                'OK!',
                                'Guardo ok.',
                                'success'
                            )
                            window.location.href = $('#url_domin').val()
                        }
                    }
                });
            }
        });
    });
  </script>
@endsection