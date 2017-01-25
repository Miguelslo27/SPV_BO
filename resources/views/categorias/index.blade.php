@extends('layouts.master')

@section('content')

<h1><span class="glyphicon glyphicon-list-alt"></span> Categorías guardadas</h1>
<p class="lead">Aquí están todas las categorías guardadas. <a href="{{ route('categorias.create') }}">Agregar una nueva</a></p>

<hr>

<div class="list-group">
@if(!count($categorias))
	<h3>No se encontraron categorías</h3>
@endif
@foreach($categorias as $categoria)
	<div class="list-group-item">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a class="btn btn-default" href="{{ route('categorias.show', $categoria->id) }}">
				<span>Ver +</span>
			</a>
			<a class="btn btn-default" href="{{ route('categorias.edit', $categoria->id) }}">
				<span class="glyphicon glyphicon-pencil"></span>
			</a>
			<a class="btn btn-default" href="{{ route('categorias.delete', $categoria->id) }}">
				<span class="glyphicon glyphicon-remove"></span>
			</a>
		</div>

	    <h4 class="list-group-item-heading">
	    	<a href="{{ route('categorias.show', $categoria->id) }}">{{ $categoria->nombre }}</a>
	    </h4>
	    
	    <p class="list-group-item-text">{{ $categoria->caracteristicas }}</p>
	    <p>Seguros asignados: <strong>{{ count($categoria->seguros) }}</strong></p>
	</div>
@endforeach
</div>

@stop