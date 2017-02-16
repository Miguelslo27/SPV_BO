@extends('layouts.master')

@section('content')

<h1>{{ $atributo->atributo }}</h1>

<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success-message')

<div class="panel panel-default">
	<div class="panel-heading">
		<a href="{{ route('atributos.index') }}" class="btn btn-info">
			<span class="glyphicon glyphicon-chevron-left"></span>
			Atrás
		</a>

		<a href="{{ route('atributos.edit', $atributo->id) }}" class="btn btn-info">
			<span class="glyphicon glyphicon-pencil"></span>
			Editar
		</a>

		<div class="pull-right">
            <a href="{{ route('atributos.delete', $atributo->id) }}" class="btn btn-danger">
                <span class="glyphicon glyphicon-remove"></span>
                Eliminar atributo
            </a>
        </div>
	</div>

	<div class="panel-body">
		<p>
			<strong>Estado: </strong><span>@if($atributo->estado == 1) Público @else Privado @endif</span>
		</p>
	</div>
</div>
<hr>
@stop