@extends('layouts.master')

@section('content')

<h1><span class="glyphicon glyphicon-plus"></span> Editando atributo "{{ $atributo->atributo }}"</h1>
<p class="lead">Edita este atributo o vuelve a la lista. <a href="{{ route('atributos.index') }}">Volver a la lista.</a></p>

<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success-message')

{!! Form::model($atributo, [
    'method' => 'PATCH',
    'route' => ['atributos.update', $atributo->id]
]) !!}

	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="{{ route('atributos.index') }}" class="btn btn-info">
				<span class="glyphicon glyphicon-chevron-left"></span>
				Atrás
			</a>
			<button type="submit" class="btn btn-primary save">
				<span class="glyphicon glyphicon-floppy-disk"></span>
				Guardar
			</button>

			<div class="pull-right">
				<span>
					<label>Requerido: </label>
	            	<input type="checkbox" class="bool" id="requerido" name="requerido" {{ $atributo->requerido ? 'checked=""' : '' }}>
	                <label for="requerido">&nbsp;</label>
	            </span>
				<span>
					<label>Estado: </label>
	                <input type="checkbox" id="estado" name="estado" {{ $atributo->estado ? 'checked=""' : '' }}>
	                <label for="estado">&nbsp;</label>
				</span>
                <a href="{{ route('atributos.delete', $atributo->id) }}" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove"></span>
                    Eliminar Atributo
                </a>
            </div>
		</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-md-6 form-group">
				    {!! Form::label('atributo', 'Nombre:', ['class' => 'control-label']) !!}
				    {!! Form::text('atributo', null, ['class' => 'form-control']) !!}
				</div>
				<div class="col-md-3 form-group">
				    {!! Form::label('aplicacion', 'A que seguros aplica:', ['class' => 'control-label']) !!}
					<select
					 id="aplicacion"
					 name="aplicacion[]"
					 data-actions-box="true"
					 data-none-selected-text="Ningún seguro seleccionado"
					 class="selectpicker"
					 multiple>
						<option value="null" disabled>Selecciona seguros...</option>
						<optgroup label="Seguros">
							@foreach($seguros as $seguro)
								@if (in_array($seguro->id, $seguros_sel) == "1")
								<option value="{{ $seguro->id }}" selected>{{ $seguro->nombre }}</option>
	                            @else
	                            <option value="{{ $seguro->id }}">{{ $seguro->nombre }}</option>
	                            @endif
							@endforeach
						</optgroup>
					</select>
				</div>
				<div class="col-md-3 form-group">
				    {!! Form::label('validacion', 'Validación:', ['class' => 'control-label']) !!}
				    <select
				     id="validacion"
					 name="validacion"
					 class="selectpicker">
						<option value="null" disabled>Selecciona validación...</option>
						<optgroup label="Validaciones disponibles">
							<option value="none" {{ $atributo->validacion == 'none' ?  'selected' : '' }}>Ninguno</option>
							<option value="numero" {{ $atributo->validacion == 'numero' ?  'selected' : '' }}>Número</option>
							<option value="ci" {{ $atributo->validacion == 'ci' ?  'selected' : '' }}>Cédula de Identidad</option>
						</optgroup>
					</select>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3 form-group">
					{!! Form::label('modelo', 'Modelo:', ['class' => 'control-label']) !!}
					<select
					 name="modelo"
					 id="modelo"
					 class="selectpicker">
					 	<option value="null" disabled>Selecciona el modelo</option>
					 	<optgroup label="Modelos aplicables">
					 		<option value="usuario" {{ $atributo->modelo == 'usuario' ? 'selected' : ''}}>Usuario</option>
					 		<option value="poliza" {{ $atributo->modelo == 'poliza' ? 'selected' : ''}}>Póliza</option>
					 		<option value="cotizacion" {{ $atributo->modelo == 'cotizacion' ? 'selected' : ''}}>Cotización</option>
					 	</optgroup>
					</select>
				</div>
				<div class="col-md-3 form-group">
				    {!! Form::label('tipo', 'Tipo de dato:', ['class' => 'control-label']) !!}
				    <select
				     id="tipo"
					 name="tipo"
					 data-target="valores"
					 class="selectpicker">
						<option value="null" disabled>Selecciona tipo de dato...</option>
						<optgroup label="Tipos disponibles">
							<option value="texto" {{ $atributo->tipo == 'texto' ?  'selected' : '' }}>Texto</option>
							<option value="numero" {{ $atributo->tipo == 'numero' ?  'selected' : '' }}>Número</option>
							<option value="moneda-peso" {{ $atributo->tipo == 'moneda-peso' ?  'selected' : '' }}>Moneda ($)</option>
							<option value="moneda-dolar" {{ $atributo->tipo == 'moneda-dolar' ?  'selected' : '' }}>Moneda (USD)</option>
							<option value="lista" {{ $atributo->tipo == 'lista' ?  'selected' : '' }}>Lista de opciones</option>
						</optgroup>
					</select>
				</div>
				<div class="col-md-3 form-group">
				    {!! Form::label('adhiere', 'Adhiere:', ['class' => 'control-label']) !!}
		    		<div class="input-group">
						<span class="input-group-addon currency">$</span>
						<span class="input-group-addon dollar left-radius-4">USD</span>
						{!! FORM::number('adhiere', $atributo->adhiere, ['class' => 'form-control']) !!}
						<span class="input-group-addon percent">%</span>
					</div>
					<div class="input-group">
						<label>Adhiere en USD: </label>
		                <input type="checkbox" class="currency" id="moneda" name="moneda" data-input="adhiere" {{ $atributo->moneda == 'USD' ? 'checked=""' : '' }}>
		                <label for="moneda">&nbsp;</label>
	                </div>
				</div>
				<div class="col-md-3 form-group">		
					<label>Adhiere con %: </label>		
	            	<input type="checkbox" class="bool" id="porcentaje" name="porcentaje" data-input="adhiere" {{ $atributo->porcentaje == 1 ? 'checked=""' : '' }}>		
	                <label for="porcentaje">&nbsp;</label>		
	                <p>* Porcentaje del valor del atributo</p>	
				</div>
			</div>

			<div class="row hidden">
                <div class="col-md-12 form-group">
                    {!! FORM::label('valores', 'Valores de la lista', ['class' => 'control-label']) !!}
                    <p>* Valores de la lista</p>
                    <textarea
					 name="valores"
					 id="valores"
					 data-type="table"
					 class="form-control hidden">{{ $atributo->valores }}</textarea>
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
                    <table id="table-valores" class="textarea-table table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Identificador (interno)</th>
								<th>Valor</th>
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