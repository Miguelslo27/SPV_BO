@extends('layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/bootstrap-iconpicker.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/iconset/iconset-fontawesome-4.3.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-iconpicker.min.js') }}"></script>
@endpush

@section('content')

<h1><span class="glyphicon glyphicon-plus"></span> Crear categoria</h1>
<p class="lead">Completa el formulario para agregar una categoría.</p>

<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success-message')

{!! Form::open([
    'route' => 'categorias.store'
]) !!}

	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="{{ route('categorias.index') }}" class="btn btn-info">
				<span class="glyphicon glyphicon-chevron-left"></span>
				Atrás
			</a>

			<button type="submit" class="btn btn-primary">
				<span class="glyphicon glyphicon-floppy-disk"></span>
				Guardar
			</button>
		</div>

		<div class="panel-body">
			<div class="form-group">
			    {!! Form::label('nombre', 'Nombre:', ['class' => 'control-label']) !!}
			    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
			    {!! Form::label('caracteristicas', 'Características:', ['class' => 'control-label']) !!}
			    <p><small>Escribe las características separadas por coma: <em><strong>Ejemplo 1, ejemplo 2</strong></em></small></p>
			    <p><small>Para agregar segunda línea a una característica, escribe entre paréntesis rectos: <em>Ejemplo 1 <strong>[Segunda línea]</strong>, Ejemplo 2</em></small></p>
			    {!! Form::text('caracteristicas', null, ['class' => 'form-control']) !!}
			</div>

			<div class="form-group">
			    {!! Form::label('icono', 'Ícono:', ['class' => 'control-label']) !!}
			    
			    &nbsp;
			    <button
                 data-iconset="fontawesome"
                 data-icon="fa-hand-o-up"
                 data-search-text="Buscar..."
                 data-cols="6"
                 data-placement="top"
                 data-unselected-class="btn-info"
                 class="btn btn-success btn-lg"
                 id="icono"
                 name="icono"
                 class="form-control"
                 type="text"
                 role="iconpicker">
                </button>

				&nbsp;
				<label>Estado:</label>
            	<input type="checkbox" id="estado" name="estado">
                <label for="estado">&nbsp;</label>

                <!-- <input type="checkbox" id="estado" name="estado">

                <a href="#" id="status" role="boolean" class="status-private">
                	<span class="fa fa-toggle-off"></span>
                	<span>Privado</span>
                </a> -->
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