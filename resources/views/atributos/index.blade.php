@extends('layouts.master')

@section('content')

<h1><span class="glyphicon glyphicon-th"></span> Atributos guardados</h1>
<p class="lead">Aquí están todos los atributos guardados. <a href="{{ route('atributos.create') }}">Agregar uno nuevo</a></p>

<hr>

<div class="list-group">
@if(!count($atributos))
	<h3>No se encontraron categorías</h3>
@endif
@foreach($atributos as $atributo)
	<div class="list-group-item">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a class="btn btn-default" href="{{ route('atributos.show', $atributo->id) }}">
				<span>Ver +</span>
			</a>
			<a class="btn btn-default" href="{{ route('atributos.edit', $atributo->id) }}">
				<span class="glyphicon glyphicon-pencil"></span>
			</a>
			<a class="btn btn-default" href="{{ route('atributos.delete', $atributo->id) }}">
				<span class="glyphicon glyphicon-remove"></span>
			</a>
		</div>

	    <h4 class="list-group-item-heading">
	    	<a href="{{ route('atributos.show', $atributo->id) }}">{{ $atributo->atributo }}</a>
	    </h4>
	</div>
@endforeach
</div>

@stop