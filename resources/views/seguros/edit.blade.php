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
                Guardar
            </button>

            <div class="pull-right">
                <a href="{{ route('seguros.delete', $seguro->id) }}" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove"></span>
                    Eliminar Seguro
                </a>
            </div>
        </div>

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
            </div>

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
                </div>
                <div class="col-md-3 form-group">
                    {!! FORM::label('pertenencia', 'Dependencia:', ['class' => 'control-label']) !!}
                    <select name="pertenencia"
                     id="pertenencia"
                     data-live-search="true"
                     class="selectpicker">
                        <option value="null">Selecciona seguro</option>
                        @foreach ($categorias as $categoria)
                        <optgroup label="{{ $categoria->nombre }}">
                            @foreach ($seguros as $seguro)
                                @if ($categoria->id == $seguro->categoria)
                                    @if ($seguro->pertenencia == $seguro->id)
                                    <option value="{{ $seguro->id }}" selected>{{ $seguro->nombre }}</option>
                                    @else
                                    <option value="{{ $seguro->id }}">{{ $seguro->nombre }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </optgroup>
                        @endforeach
                     </select>
                </div>
                <div class="col-md-3 form-group">
                    {!! FORM::label('valor', 'Valor:', ['class' => 'control-label']) !!}
                    <div class="input-group">
                        <span class="input-group-addon currency">$</span>
                        {!! FORM::number('valor', $seguro->valor, ['class' => 'form-control']) !!}
                        <span class="input-group-addon percent">%</span>
                    </div>
                </div>
                <div class="col-md-3 form-group">
                    <label>Valor en %: </label>
                        <input type="checkbox" class="bool" id="porcentaje" name="porcentaje" {{ $seguro->porcentaje ? 'checked=""' : '' }}>
                    <label for="porcentaje">&nbsp;</label>
                    <p>* Porcentaje del valor del producto asegurado</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group">
                    {!! FORM::label('pago', 'Recurrencia de pago:', ['class' => 'control-label']) !!}
                    {{ $seguro->pago }}
                    <select name="pago"
                     id="pago"
                     class="selectpicker">
                        <option value="null">Selecciona recurrencia</option>
                        <option value="mensual" {{ $seguro->pago == 'mensual' ? 'selected' : '' }}>Mensual</option>
                        <option value="anual" {{ $seguro->pago == 'anual' ? 'selected' : '' }}>Anual</option>
                     </select>
                </div>

                <div class="col-md-3 form-group">
                    {!! FORM::label('unidad_cobertura', 'Cobertura:', ['class' => 'control-label']) !!}
                    <div class="row">
                        <div class="col-xs-6">
                            <input type="number" value="{{ $seguro->valor_cobertura }}" class="form-control" name="valor_cobertura" id="valor_cobertura">
                        </div>
                        <div class="col-xs-6">
                            <strong class="unidad-cobertura"></strong>
                        </div>
                    </div>
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
                    </div>
                </div>

                <div class="col-md-3 form-group">
                    {!! FORM::label('aseguradora', 'Aseguradora:', ['class' => 'control-label']) !!}
                    <select name="aseguradora"
                     id="aseguradora"
                     class="selectpicker">
                        <option value="null">Selecciona aseguradora</option>
                        <option value="mapfre" {{ $seguro->aseguradora == 'mapfre' ?  'selected' : '' }}>Mapfre</option>
                        <option value="uruguay-asistencia" {{ $seguro->aseguradora == 'uruguay-asistencia' ?  'selected' : '' }}>Uruguay Asistencia</option>
                    </select>
                </div>
            </div>

            <!--
            coberturas
            premio_anual
            -->
            <div class="row">
                <div class="col-md-12 form-group">
                    {!! FORM::label('coberturas', 'Descripción de cobertura', ['class' => 'control-label']) !!}
                    <p>* Tabla de características de la cobertura</p>
                    <textarea
                     name="coberturas"
                     id="coberturas"
                     data-type="table"
                     class="form-control hidden">{{ $seguro->coberturas }}</textarea>
                    <style>
                        .table.textarea-table span {
                            display: block;
                            box-sizing: border-box;
                            width: 100%;
                            min-height: 30px;
                            line-height: 30px;
                            padding: 0 10px;
                            border: 1px solid #ddd;
                            background: #fff;
                        }
                        .table.textarea-table span.table-row-actions {
                            background: none;
                            border: none;
                            text-align: center;
                        }
                    </style>
                    <table id="table-coberturas" class="textarea-table table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre de la propiedad</th>
                                <th>Atributo de la propiedad</th>
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
                                <td class="col-md-5"><span class="table-field" contenteditable="true"></span></td>
                                <td class="col-md-5"><span class="table-value" contenteditable="true"></span></td>
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
                                <td class="col-md-5"><span class="table-field" contenteditable="true"></span></td>
                                <td class="col-md-5"><span class="table-value" contenteditable="true"></span></td>
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
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    {!! FORM::label('premio_anual', 'Descripción de premio anual a pagar', ['class' => 'control-label']) !!}
                    <p>* Tabla de los premios anuales</p>
                    <textarea
                     name="premio_anual"
                     id="premio_anual"
                     data-type="table"
                     class="form-control hidden">{{ $seguro->premio_anual }}</textarea>
                    <table id="table-premio_anual" class="textarea-table table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre de la propiedad</th>
                                <th>Atributo de la propiedad</th>
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
                                <td class="col-md-5"><span class="table-field" contenteditable="true"></span></td>
                                <td class="col-md-5"><span class="table-value" contenteditable="true"></span></td>
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
                                <td class="col-md-5"><span class="table-field" contenteditable="true"></span></td>
                                <td class="col-md-5"><span class="table-value" contenteditable="true"></span></td>
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
                    </table>
                </div>
            </div>

            <div class="form-group">
                <label>Estado: </label>
                <input type="checkbox" id="estado" name="estado" {{ $seguro->estado ? 'checked=""' : '' }}>
                <label for="estado">&nbsp;</label>
            </div>
        </div>

        <div class="panel-footer">
            <button type="submit" class="btn btn-primary save">
                <span class="glyphicon glyphicon-floppy-disk"></span>
                Guardar
            </button>
        </div>
    </div>

{!! Form::close() !!}

@stop