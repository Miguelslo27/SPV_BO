@extends('layouts.master')

@section('content')

<h1><span class="glyphicon glyphicon-plus"></span> Crear atributo</h1>
<p class="lead">Completa el formulario para agregar un atributo.</p>

<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success-message')

{!! Form::open([
    'route' => 'atributos.store'
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
	            	<input type="checkbox" class="bool" id="requerido" name="requerido">
	                <label for="requerido">&nbsp;</label>
	            </span>
				<span>
					<label>Estado: </label>
	            	<input type="checkbox" id="estado" name="estado">
	                <label for="estado">&nbsp;</label>
	            </span>
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
							<option value="{{ $seguro->id }}">{{ $seguro->nombre }}</option>
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
							<option value="none" selected>Ninguno</option>
							<option value="numero">Número</option>
							<option value="email">Email</option>
							<option value="ci">Cédula de Identidad</option>
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
					 		<option value="usuario">Usuario</option>
					 		<option value="poliza">Póliza</option>
					 		<option value="cotizacion">Cotización</option>
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
							<option value="texto">Texto</option>
							<option value="numero">Número</option>
							<option value="moneda-peso">Moneda ($)</option>
							<option value="moneda-dolar">Moneda (USD)</option>
							<option value="lista">Lista de opciones</option>
						</optgroup>
					</select>
				</div>
				<div class="col-md-3 form-group">
				    {!! Form::label('adhiere', 'Adhiere:', ['class' => 'control-label']) !!}
		    		<div class="input-group">
						<span class="input-group-addon currency">$</span>
						<span class="input-group-addon dollar left-radius-4">USD</span>
						{!! FORM::number('adhiere', 0, ['class' => 'form-control']) !!}
						<span class="input-group-addon percent">%</span>
					</div>
					<div class="input-group">
						<label>Adhiere en USD: </label>
		                <input type="checkbox" class="currency" id="moneda" name="moneda" data-input="adhiere">
		                <label for="moneda">&nbsp;</label>
	                </div>
					<div class="input-group">		
						<label>Adhiere con %: </label>		
		            	<input type="checkbox" class="bool" id="porcentaje" name="porcentaje" data-input="adhiere">		
		                <label for="porcentaje">&nbsp;</label>		
		                <p>* Porcentaje del valor del atributo</p>	
					</div>
				</div>
				<div class="col-md-3 form-group">		
					{!! Form::label('orden', 'Orden:', ['class' => 'control-label']) !!}
	            	{!! FORM::number('orden', 0, ['class' => 'form-control']) !!}
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
					 class="form-control hidden"></textarea>
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