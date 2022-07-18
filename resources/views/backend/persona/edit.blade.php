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
  
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title" style="display: inline;">Editar Persona</h3>
                  <a href="{{route('personas.index')}}" class="btn btn-sm btn-default float-right"><i class="fas fa-reply-all"> Atrás</i>
                  </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  {!! Form::model($persona,['route'=>['personas.update',$persona],'method'=>'put']) !!}
                    <div class="form-row">                    
                      <div class="form-group col-md-4">
                        {!! Form::label('nombres','Nombres *',['for'=>'imputNombres'])  !!}
                        {!! Form::text('nombres',$persona->nombres,['class'=>'form-control', 'placeholder'=>'Nombres']) !!}
                        @error('nombres')
                          <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>
                      <div class="form-group col-md-4">
                        {!! Form::label('apellidos','Apellidos *',['for'=>'inputApellidos'])  !!}
                        {!! Form::text('apellidos',$persona->apellidos,['class'=>'form-control', 'placeholder'=>'Apellidos']) !!}
                        @error('apellidos')
                          span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>
                      <div class="form-group col-md-4">
                        {!! Form::label('sexo','Sexo',['for'=>'inputSexo'])  !!}
                        {!! Form::select('sexo',['1'=>'Hombre', '2'=>'Mujer', '3'=>'No definido'],$persona->sexo,['class'=>'form-control']) !!}
                      </div>
                    </div>
                    <div class="form-row">                    
                      <div class="form-group col-md-3">
                        {!! Form::label('tipo_documentos_id','Tipo Documento',['for'=>'inputTipoDocumentoId'])  !!}
                        {!! Form::select('tipo_documentos_id',$documentos,$persona->tipo_documentos_id,['class'=>'form-control']) !!}
                      </div>                    
                      <div class="form-group col-md-3">
                        {!! Form::label('numero_documento','# documento',['for'=>'inputNumeroDocumento'])  !!}
                        {!! Form::text('numero_documento',$persona->numero_documento,['class'=>'form-control', 'placeholder'=>'# documento']) !!}
                      </div>                    
                      <div class="form-group col-md-3">
                        {!! Form::label('fecha_nacimiento','Fecha Nacimiento',['for'=>'inputFechaNacimiento'])  !!}
                        {!! Form::date('fecha_nacimiento',$persona->fecha_nacimiento,['class'=>'form-control', 'placeholder'=>'Fecha Nacimiento']) !!}
                      </div>
                      <div class="form-group col-md-3">
                        {!! Form::label('celular','Celular',['for'=>'inputCelular'])  !!}
                        {!! Form::text('celular',$persona->celular,['class'=>'form-control', 'maxlength'=>'9', 'placeholder'=>'Celular']) !!}
                      </div>
                    </div>
                    <div class="form-row">                   
                      <div class="form-group col-md-4">
                        {!! Form::label('departamentos_id','Departamento',['for'=>'inputDepartamento'])  !!}
                        {!! Form::select('departamentos_id',$departamentos,$persona->departamentos_id,['class'=>'form-control']) !!}
                      </div>
                      <div class="form-group col-md-4">
                        {!! Form::label('provincias_id','Provincia',['for'=>'inputProvincia'])  !!}
                        {!! Form::select('provincias_id',$provincias,$persona->provincias_id,['class'=>'form-control']) !!}
                      </div>
                      <div class="form-group col-md-4">
                        {!! Form::label('distritos_id','Distrito',['for'=>'inputDistrito'])  !!}
                        {!! Form::select('distritos_id',$distritos,$persona->distritos_id,['class'=>'form-control']) !!}
                      </div>
                    </div>
                    <div class="form-group row">
                      {!! Form::label('direccion','Dirección',['class'=>'col-sm-2 col-form-label text-right'])  !!}
                      <div class="col-sm-10">
                        {!! Form::text('direccion',$persona->direccion,['class'=>'form-control', 'placeholder'=>'Dirección']) !!}
                      </div>
                    </div>
                    <div class="form-group row">
                      {!! Form::label('referencia','Referencia',['class'=>'col-sm-2 col-form-label text-right'])  !!}
                      <div class="col-sm-10">
                        {!! Form::text('referencia',$persona->referencia,['class'=>'form-control', 'placeholder'=>'Referencia']) !!}
                      </div>
                    </div>
                    {!! Form::submit('Actualizar Persona',['class'=>'btn btn-primary']) !!}
                  {!! Form::close() !!}
                  @foreach ($digitos as $ki=>$digito)
                    <input type="hidden" class="digitos_{{$ki}}" value="{{$digito}}">
                  @endforeach
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
<script src="{{asset('js/persona/ubigeo.js')}}"></script>
<!-- Page specific script -->
<script>
</script>
@endsection