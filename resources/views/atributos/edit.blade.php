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
			<button type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-floppy-disk"></span>
				Guardar
			</button>

			<div class="pull-right">
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
							<option value="none" selected>Ninguno</option>
							<option value="ci">Cédula de Identidad</option>
						</optgroup>
					</select>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6 form-group">
				    {!! Form::label('tipo', 'Tipo de dato:', ['class' => 'control-label']) !!}
				    <select
				     id="tipo"
					 name="tipo"
					 class="selectpicker">
						<option value="null" disabled>Selecciona tipo de dato...</option>
						<optgroup label="Tipos disponibles">
							<option value="texto">Texto</option>
							<option value="numero">Número</option>
							<option value="moneda-peso">Moneda ($)</option>
							<option value="moneda-dolar">Moneda (USD)</option>
						</optgroup>
					</select>
				</div>
				<div class="col-md-3 form-group">
				    {!! Form::label('adhiere', 'Adhiere:', ['class' => 'control-label']) !!}
		    		<div class="input-group">
						<span class="input-group-addon currency">$</span>
						{!! FORM::number('adhiere', 0, ['class' => 'form-control']) !!}
					</div>
				</div>
				<div class="col-md-3 form-group">
				    {!! Form::label('cubre', 'Cubre el:', ['class' => 'control-label']) !!}
					<div class="input-group">
						{!! FORM::number('cubre', 0, ['class' => 'form-control']) !!}
						<span class="input-group-addon currency">%</span>
					</div>
				</div>
			</div>
			
			<div class="form-group">
                <label>Estado: </label>
                <input type="checkbox" id="estado" name="estado" {{ $atributo->estado ? 'checked=""' : '' }}>
                <label for="estado">&nbsp;</label>
			</div>
		</div>

		<div class="panel-footer">
			<button type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-floppy-disk"></span>
				Guardar
			</button>
		</div>
	</div>

{!! Form::close() !!}

@stop