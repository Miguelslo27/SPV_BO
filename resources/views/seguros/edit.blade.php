@extends('layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/bootstrap-iconpicker.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/iconset/iconset-fontawesome-4.3.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-iconpicker.min.js') }}"></script>
@endpush

@section('content')

<h1><span class="glyphicon glyphicon-plus"></span> Editando seguro "{{ $seguro->nombre }}"</h1>
<p class="lead">Edita este seguro o vuelve a la lista. <a href="{{ route('seguros.index') }}">Volver a la lista.</a></p>

<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success-message')

{!! Form::model($seguro, [
  'method' => 'PATCH',
  'route' => ['seguros.update', $seguro->id]
]) !!}

<div class="panel panel-default">
  <div class="panel-heading">
    <a href="{{ route('seguros.index') }}" class="btn btn-info">
      <span class="glyphicon glyphicon-chevron-left"></span>
      Atrás
    </a>
    <button type="submit" class="btn btn-primary save">
      <span class="glyphicon glyphicon-floppy-disk"></span>
      Guardar cambios
    </button>
    <a href="#" class="btn btn-default upload-file" data-toggle="modal" data-target="#filesystem">
      <input type="hidden" name="condiciones" id="condiciones" value="{{ $seguro->condiciones }}">
      <span class="fa fa-file-pdf-o"></span>
      <span class="condiciones-text">{{ $seguro->condiciones ? str_replace('/filesystem/pdf/download/', '', $seguro->condiciones) : 'Agregar condiciones al seguro' }}</span>
    </a>
    <div class="pull-right">
      <span>
        <label>Estado: </label>
        <input type="checkbox" id="estado" name="estado" {{ $seguro->estado ? 'checked=""' : '' }}>
        <label for="estado">&nbsp;</label>
      </span>
      <a href="{{ route('seguros.delete', $seguro->id) }}" class="btn btn-danger">
        <span class="glyphicon glyphicon-remove"></span>
        Eliminar Seguro
      </a>
    </div>
  </div> <!-- /.panel-heading -->

  <div class="panel-body">
    <div class="row">
      <div class="col-md-3 form-group">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'control-label']) !!}
        {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
      </div>
      <div class="col-md-9 form-group">
        {!! Form::label('descripcion', 'Descripción breve:', ['class' => 'control-label']) !!}
        {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
      </div>
    </div> <!-- /.row -->

    <div class="row">
      <div class="col-md-3 form-group">
        {!! FORM::label('categoria', 'Categoria:', ['class' => 'control-label']) !!}
        <select id="categoria"
         name="categoria"
         data-live-search="true"
         class="selectpicker">
          <option value="null">Selecciona categoría...</option>
          <optgroup label="Categorías">
            @foreach ($categorias as $categoria)
              @if ($categoria->id ==  $seguro->categoria)
              <option value="{{ $categoria->id }}" selected>{{ $categoria->nombre }}</option>
              @else
              <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
              @endif
            @endforeach
          </optgroup>
        </select>
      </div> <!-- /.col-md-3.form-group -->

      <div class="col-md-3 form-group">
        {!! FORM::label('pertenencia', 'Dependencia:', ['class' => 'control-label']) !!}
        <select name="pertenencia"
         id="pertenencia"
         data-live-search="true"
         class="selectpicker">
          <option value="null">Selecciona seguro</option>
          @foreach ($categorias as $categoria)
          <optgroup label="{{ $categoria->nombre }}">
            @foreach ($seguros as $pertenencia)
              @if ($categoria->id == $seguro->categoria)
              <option value="{{ $pertenencia->id }}" {{ ($seguro->pertenencia == $pertenencia->id && $seguro->id != $pertenencia->id) ? 'selected' : '' }} {{ $seguro->id == $pertenencia->id ? 'disabled' : '' }}>{{ $pertenencia->nombre }}</option>
              @endif
            @endforeach
          </optgroup>
          @endforeach
        </select>
      </div> <!-- /.col-md-3.form-group -->

      <div class="col-md-3 form-group">
        {!! FORM::label('valor', 'Valor del seguro:', ['class' => 'control-label']) !!}
        <div class="input-group">
          <span class="input-group-addon currency">$</span>
          <span class="input-group-addon dollar left-radius-4">USD</span>
          {!! FORM::number('valor', $seguro->valor, ['class' => 'form-control']) !!}
        </div> <!-- /.input-group -->

        <div class="input-group">
          <label>Valor en USD: </label>
          <input type="checkbox" class="currency" id="moneda" name="moneda" data-input="valor" {{ $seguro->moneda == 'USD' ? 'checked=""' : '' }}>
          <label for="moneda">&nbsp;</label>
        </div> <!-- /.input-group -->
      </div> <!-- /.col-md-3.form-group -->

      <div class="col-md-3 form-group">
        {!! FORM::label('pago', 'Recurrencia de pago:', ['class' => 'control-label']) !!}
        <select name="pago"
         id="pago"
         class="selectpicker">
          <option value="null">Selecciona recurrencia</option>
          <option value="mensual" {{ $seguro->pago == 'mensual' ? 'selected' : '' }}>Mensual</option>
          <option value="anual" {{ $seguro->pago == 'anual' ? 'selected' : '' }}>Anual</option>
         </select>
      </div> <!-- /.col-md-3.form-group -->
    </div> <!-- /.row -->

    <div class="row">
      <div class="col-md-3 form-group">       
        {!! Form::label('orden', 'Orden:', ['class' => 'control-label']) !!}
        {!! FORM::number('orden', $seguro->orden, ['class' => 'form-control']) !!}
      </div> <!-- /.col-md-3.form-group -->

      <div class="col-md-3 form-group">
        {!! FORM::label('unidad_cobertura', 'Cobertura:', ['class' => 'control-label']) !!}
        <div class="row">
          <div class="col-xs-6">
            <input type="number" value="{{ $seguro->valor_cobertura }}" class="form-control" name="valor_cobertura" id="valor_cobertura">
          </div>
          <div class="col-xs-6">
            <strong class="unidad-cobertura"></strong>
          </div>
        </div> <!-- /.row -->
        <br>

        <div class="row">
          <div class="col-xs-12">
            <select name="unidad_cobertura"
             id="unidad_cobertura"
             class="selectpicker">
              <option value="null">Selecciona cobertura</option>
              <option value="mensual" {{ $seguro->unidad_cobertura == 'mensual' ?  'selected' : '' }}>Meses</option>
              <option value="anual" {{ $seguro->unidad_cobertura == 'anual' ?  'selected' : '' }}>Años</option>
            </select>
          </div>
        </div> <!-- /.row -->
      </div> <!-- /.col-md-3.form-group -->

      <div class="col-md-3 form-group">
        {!! FORM::label('aseguradora', 'Aseguradora:', ['class' => 'control-label']) !!}
        <select name="aseguradora"
         id="aseguradora"
         class="selectpicker">
          <option value="null">Selecciona aseguradora</option>
          <option value="mapfre" {{ $seguro->aseguradora == 'mapfre' ?  'selected' : '' }}>Mapfre</option>
          <option value="uruguay-asistencia" {{ $seguro->aseguradora == 'uruguay-asistencia' ?  'selected' : '' }}>Uruguay Asistencia</option>
        </select>
      </div> <!-- /.col-md-3.form-group -->

      <div class="col-md-3 form-group">
        <label>Requerir comprobantes: </label>
        <br>
        <input type="checkbox" class="bool" id="comprobar" name="comprobar" {{ $seguro->comprobar ? 'checked=""' : '' }}>
        <label for="comprobar">&nbsp;</label>
      </div> <!-- /.col-md-3.form-group -->
    </div> <!-- /.row -->

    <!-- coberturas -->
    <div class="row">
      <div class="col-md-12 form-group">
        {!! FORM::label('coberturas', 'Descripción de cobertura', ['class' => 'control-label']) !!}
        <p>* Tabla de características de la cobertura</p>
        <textarea
         name="coberturas"
         id="coberturas"
         data-type="object"
         class="form-control">{{ $seguro->coberturas }}</textarea>
        <table id="object-coberturas" class="textarea-table table table-striped table-hover">
          <thead>
            <tr>
              <th>Cobertura</th>
              <th>Valor de la cobertura</th>
              <th>
                <span class="table-row-actions">
                  <a href="#"
                   class="btn glyphicon glyphicon-plus"
                   data-toggle="tooltip"
                   data-placement="left"
                   title="Agregar fila"></a>
                </span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="row-template hidden">
              <td class="col-md-5"><input type="text" data-key="cobertura"></td>
              <td class="col-md-5"><input type="text" data-key="valor"></td>
              <td class="col-md-1 col-md-offset-1">
                <span class="table-row-actions">
                  <a href="#"
                   class="btn glyphicon glyphicon-minus"
                   data-toggle="tooltip"
                   data-placement="left"
                   title="Eliminar fila"></a>
                </span>
              </td>
            </tr>
            <tr>
              <td class="col-md-5"><input type="text" data-key="cobertura"></td>
              <td class="col-md-5"><input type="text" data-key="valor"></td>
              <td class="col-md-1 col-md-offset-1">
                <span class="table-row-actions">
                  <a href="#"
                   class="btn glyphicon glyphicon-minus"
                   data-toggle="tooltip"
                   data-placement="left"
                   title="Eliminar fila"></a>
                </span>
              </td>
            </tr>
          </tbody>
        </table> <!-- /#coberturas -->
      </div> <!-- /.col-md-12.form-group -->
    </div> <!-- /.row -->
    <!-- /coberturas -->

    <!-- premio_anual -->
    <div class="row">
      <div class="col-md-12 form-group">
        {!! FORM::label('premio_anual', 'Descripción de premio anual a pagar', ['class' => 'control-label']) !!}
        <p>* Tabla de los premios anuales</p>
        <textarea
         name="premio_anual"
         id="premio_anual"
         data-type="object"
         class="form-control">{{ $seguro->premio_anual }}</textarea>
        <table id="object-premio_anual" class="textarea-table table table-striped table-hover">
          <thead>
            <tr>
              <th>Premio anual</th>
              <th>Valor del premio anual</th>
              <th>
                <span class="table-row-actions">
                  <a href="#"
                   class="btn glyphicon glyphicon-plus"
                   data-toggle="tooltip"
                   data-placement="left"
                   title="Agregar fila"></a>
                </span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="row-template hidden">
              <td class="col-md-5"><input type="text" data-key="premio"></td>
              <td class="col-md-5"><input type="text" data-key="valor_anual"></td>
              <td class="col-md-1 col-md-offset-1">
                <span class="table-row-actions">
                  <a href="#"
                   class="btn glyphicon glyphicon-minus"
                   data-toggle="tooltip"
                   data-placement="left"
                   title="Eliminar fila"></a>
                </span>
              </td>
            </tr>
            <tr>
              <td class="col-md-5"><input type="text" data-key="premio"></td>
              <td class="col-md-5"><input type="text" data-key="valor_anual"></td>
              <td class="col-md-1 col-md-offset-1">
                <span class="table-row-actions">
                  <a href="#"
                   class="btn glyphicon glyphicon-minus"
                   data-toggle="tooltip"
                   data-placement="left"
                   title="Eliminar fila"></a>
                </span>
              </td>
            </tr>
          </tbody>
        </table> <!-- /#premio_anual -->
      </div> <!-- /.col-md-12.form-group -->
    </div> <!-- /.row -->
    <!-- /premio_anual -->
  </div> <!-- /.panel-body -->

  <div class="panel-footer">
    <button type="submit" class="btn btn-primary save">
      <span class="glyphicon glyphicon-floppy-disk"></span>
      Guardar cambios
    </button>
  </div> <!-- /.panel-footer -->
</div> <!-- /.panel -->

{!! Form::close() !!}

<div class="modal fade" id="filesystem" tabindex="-1" role="dialog" aria-labelledby="filesystemLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">
          <span class="fa fa-files-o"></span>
          Archivos
        </h4>
      </div> <!-- /.modal-header -->

      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">
              <div class="col-title">
                <h3>Detalles</h3>
              </div> <!-- /.col-title -->

              <div class="col-content">
                <p>No se ha seleccionado ningún archivo</p>
              </div> <!-- /.col-content -->
            </div> <!-- /.col-md-4 -->

            <div class="col-md-8">
              <div class="col-title">
                <h3>Archivos</h3>
                <span id="csrf_token_val" class="hidden">{{ csrf_token() }}</span>
              </div> <!-- /.col-title -->

              @if (count($archivos))
              <div class="col-commands">
                <span><strong>Archivos:</strong> <span class="count-files">{{ count($archivos) }}</span></span>
                <form action="/filesystem/add" id="upload-file" class="pull-right">
                  <span class="btn btn-default btn-file">
                  <span class="upload-file-name">Agregar archivo</span> <input type="file" id="upload-new-file">
                  </span>
                  <input type="hidden" id="csrf_token" disabled value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-primary fa fa-cloud-upload hidden"></button>
                </form>
              </div> <!-- /.col-commands -->

              <div class="col-content">
                <div class="files-container">
                  @foreach ($archivos as $archivo)
                  <div class="file-wrap"
                   data-mimetype="{{ $archivo['mimeType'] }}"
                   data-filename="{{ $archivo['name'] }}"
                   data-size="{{ $archivo['size'] }}"
                   data-lastmodified="{{ $archivo['lastModified'] }}"
                   data-viewpath="{{ $archivo['view_path'] }}"
                   data-deletepath="{{ $archivo['trash_path'] }}"
                   data-downloadpath="{{ $archivo['download_path'] }}"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="{{ $archivo["name"] }}">
                    <span class="fa fa-file-{{ $archivo['mimeType'] == 'application/pdf' ? 'pdf-' : '' }}o"></span>
                    <span class="file-name">
                      <a href="{{ $archivo['view_path'] }}" target="_blank" class="file-link">{{ substr($archivo["name"], 0, 16) }}...</a>
                    </span>
                    <span class="fa fa-check hidden"></span>
                    <div class="file-commands">
                      <div class="buttons">
                        <a href="{{ $archivo['view_path'] }}"
                          target="_blank"
                          class="fa fa-eye file-command"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Abrir"></a>
                        <a href="{{ $archivo['download_path'] }}"
                          class="fa fa-cloud-download file-command"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Descargar"></a>
                        <a href="{{ $archivo['trash_path'] }}"
                          class="fa fa-trash file-command"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="Eliminar"></a>
                      </div> <!-- /.buttons -->
                    </div> <!-- /.file-commands -->
                  </div> <!-- /.file-wrap -->
                @endforeach
                </div> <!-- /.files-container -->
              </div> <!-- /.col-content -->
              @else
              <div class="col-content">
                <p>No se han encontrado archivos</p>
                <form action="/filesystem/add" id="upload-file">
                  <span class="btn btn-default btn-file">
                  <span class="upload-file-name">Agregar archivo</span> <input type="file" id="upload-new-file">
                  </span>
                  <input type="hidden" id="csrf_token" disabled value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-primary fa fa-cloud-upload hidden"></button>
                </form>
              </div> <!-- /.col-content -->
              @endif
            </div> <!-- /.col-md-8 -->
          </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
      </div> <!-- /.modal-body -->

      <div class="modal-footer bg-success">
        <button type="button" class="btn btn-default bnt-cancel" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary btn-select-file" id="seleccionar-archivo">Seleccionar</button>
      </div> <!-- /.modal-footer -->
    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

@stop