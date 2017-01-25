@extends('layouts.master')

@section('content')

<h1><span class="glyphicon glyphicon-home"></span> Resumen Back Office</h1>
<p class="lead">Administración de la base de datos</p>

<hr>

<div class="list-group">
	<div class="list-group-item">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a class="btn btn-default" href="{{ route('categorias.create') }}">
				<span class="glyphicon glyphicon-plus"></span>
			</a>
			<a class="btn btn-default" href="{{ route('categorias.index') }}">
				<span class="glyphicon glyphicon-th-list"></span>
			</a>
		</div>
		<h4 class="list-group-item-heading"><a href="{{ route('categorias.index') }}">Categorías</a></h4>
		<p class="list-group-item-text">Lista, agrega, edita o elimina categorías del sitio...</p>
	</div>

	<div class="list-group-item">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a class="btn btn-default" href="{{ route('seguros.create') }}">
				<span class="glyphicon glyphicon-plus"></span>
			</a>
			<a class="btn btn-default" href="{{ route('seguros.index') }}">
				<span class="glyphicon glyphicon-th-list"></span>
			</a>
		</div>
		<h4 class="list-group-item-heading"><a href="{{ route('seguros.index') }}">Seguros</a></h4>
		<p class="list-group-item-text">Lista, agrega, edita o elimina seguros del sitio...</p>
	</div>

	<div class="list-group-item">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a class="btn btn-default" href="{{ route('atributos.create') }}">
				<span class="glyphicon glyphicon-plus"></span>
			</a>
			<a class="btn btn-default" href="{{ route('atributos.index') }}">
				<span class="glyphicon glyphicon-th-list"></span>
			</a>
		</div>
		<h4 class="list-group-item-heading"><a href="{{ route('atributos.index') }}">Atributos</a></h4>
		<p class="list-group-item-text">Lista, agrega, edita o elimina atributos de los seguros, puedes hacerlo directo en cada seguro para evitar errores...</p>
	</div>

	<div class="list-group-item disabled">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a class="btn btn-default disabled" href="#">
				<span class="glyphicon glyphicon-th-list"></span>
			</a>
		</div>
		<h4 class="list-group-item-heading"><a href="#" class="disabled">Pólizas</a></h4>
		<p class="list-group-item-text">Lista las pólizas contratadas a través del sitio web...</p>
	</div>

	<div class="list-group-item disabled">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a class="btn btn-default disabled" href="#">
				<span class="glyphicon glyphicon-th-list"></span>
			</a>
		</div>
		<h4 class="list-group-item-heading "><a href="#" class="disabled">Usuarios</a></h4>
		<p class="list-group-item-text">Lista los usuarios potenciales que han contratado pólizas a través del sitio...</p>
	</div>

	<div class="list-group-item disabled">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a class="btn btn-default disabled" href="#">
				<span class="glyphicon glyphicon-plus"></span>
			</a>
			<a class="btn btn-default disabled" href="#">
				<span class="glyphicon glyphicon-th-list"></span>
			</a>
		</div>
		<h4 class="list-group-item-heading"><a href="#" class="disabled">Aseguradoras</a></h4>
		<p class="list-group-item-text">Lista, agrega, edita o elimina las empresas aseguradoras con las que trabajas...</p>
	</div>

	<div class="list-group-item disabled">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<a class="btn btn-default disabled" href="#">
				<span class="glyphicon glyphicon-plus"></span>
			</a>
			<a class="btn btn-default disabled" href="#">
				<span class="glyphicon glyphicon-th-list"></span>
			</a>
		</div>
		<h4 class="list-group-item-heading"><a href="#" class="disabled">Formas de Pago</a></h4>
		<p class="list-group-item-text">Lista, agrega, edita o elimina las formas de pago con las que trabajas...</p>
	</div>
</div>

@stop