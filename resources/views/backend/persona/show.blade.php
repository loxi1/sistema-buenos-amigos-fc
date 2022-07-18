@extends('backend.layouts.app')
@section('css_contenido')
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Personas Ver</h1>
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
                    <h3 class="card-title" style="display: inline">Lista de Personas</h3>
                    <a href="{{route('personas.create')}}" class="btn btn-sm btn-primary float-right"><i class="fas fa-clone"></i>
                    </a>
                    </div>
                    <!-- /.card-header -->                    
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
<!-- Page specific script -->
<script>
   
  </script>
@endsection