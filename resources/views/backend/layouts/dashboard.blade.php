@extends('backend.layouts.app')
@section('css_contenido')
    
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard xxx {{auth()->user()->roles}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- COLOR PALETTE -->
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tag"></i> Color Palette</h3>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <h5>Theme Colors</h5>
                    </div>
                    <div class="row">
                        Personal
                    </div>
                </div>
            </div>
            <!-- ./ COLOR PALETTE -->
        </div>
    </section>
    <!-- /. Main content -->

  
  </div>    
  @endsection
  @section('js_contenido')      
    
  @endsection