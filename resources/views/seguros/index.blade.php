@extends('layouts.master')

@section('content')

<h1><span class="glyphicon glyphicon-list-alt"></span> Seguros guardados</h1>
<p class="lead">Aquí están todas los seguros guardados. <a href="{{ route('seguros.create') }}">Agregar uno nuevo</a></p>

<hr>

<div class="list-group">
@if(!count($seguros))
	<h3>No se encontraron seguros</h3>
@endif
@foreach($seguros as $seguro)
	<div class="list-group-item">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a class="btn btn-default" href="{{ route('seguros.show', $seguro->id) }}">
				<span>Ver +</span>
			</a>
			<a class="btn btn-default" href="{{ route('seguros.edit', $seguro->id) }}">
				<span class="glyphicon glyphicon-pencil"></span>
			</a>
			<a class="btn btn-default" href="{{ route('seguros.delete', $seguro->id) }}">
				<span class="glyphicon glyphicon-remove"></span>
			</a>
		</div>

	    <h4 class="list-group-item-heading">
	    	<a href="{{ route('seguros.show', $seguro->id) }}">{{ $seguro->nombre }}</a>
	    </h4>
	    
	    <p class="list-group-item-text">Atributos: 0</p>
	</div>
@endforeach
</div>

@stop