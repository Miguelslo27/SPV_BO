@extends('layouts.master')

@section('content')

<h1>{{ $seguro->nombre }}</h1>

<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success-message')

<div class="panel panel-default">
	<div class="panel-heading">
		<a href="{{ route('seguros.index') }}" class="btn btn-info">
			<span class="glyphicon glyphicon-chevron-left"></span>
			Atrás
		</a>

		<a href="{{ route('seguros.edit', $seguro->id) }}" class="btn btn-info">
			<span class="glyphicon glyphicon-pencil"></span>
			Editar
		</a>

		<div class="pull-right">
            <a href="{{ route('seguros.delete', $seguro->id) }}" class="btn btn-danger">
                <span class="glyphicon glyphicon-remove"></span>
                Eliminar Seguro
            </a>
        </div>
	</div>

	<div class="panel-body">
		<!-- <pre>{{ $seguro }}</pre> -->
		<p>
			<strong>Pertenece a la categoría </strong><a href="{{ route('categorias.show', $seguro->categoria_padre->id) }}"><span><span class="fa {{ $seguro->categoria_padre->icono }}"></span> {{ $seguro->categoria_padre->nombre }}</span></a>
		</p>
		<p> <!-- TODO - Obtener dependencia (pertenencia) por relación -->
			<strong>Dependencia: </strong><span>@if($seguro->pertenencia != 0) <a href="#">Cobertura por robo</a> @else No tiene @endif</span>
		</p>
		<p>
			<strong>Precio: </strong><span>@if($seguro->porcentaje == 0) $ @endif {{ $seguro->valor }} @if($seguro->porcentaje == 1) % @endif</span>
		</p>
		<p>
			<strong>Cobertura: </strong><span>{{ $seguro->valor_cobertura }} / {{ $seguro->unidad_cobertura }}</span>
		</p>
		<p>
			<strong>Aseguradora: </strong><span>{{ $seguro->aseguradora }}</span>
		</p>
		<p>
			<strong>Estado: </strong><span>@if($seguro->estado == 1) Público @else Privado @endif</span>
		</p>
	</div>
</div>

<hr>

<h3>Atributos de este seguro</h3>
<div class="panel panel-default">
	<div class="panel-body">
		{{-- @if(count($categoria->seguros))
		<table class="table table-striped">
			<thead>
				<tr>
					<td><strong>Seguro</strong></td>
					<td><strong>Porcentaje del valor</strong></td>
					<td><strong>Costo</strong></td>
					<td><strong>Cobertura</strong></td>
					<td><strong>Aseguradora</strong></td>
					<td><strong>Estado</strong></td>
				</tr>
			</thead>
			<tbody>
				@foreach($categoria->seguros as $seguro)
				<tr>
					<td>
						<span><a href="{{ route('seguros.show', $seguro->id) }}">{{ $seguro->nombre }}</a></span>
					</td>
					<td>
						<span>@if($seguro->porcentaje == 1) Si @else No @endif</span>
					</td>
					<td>
						<span>
							@if($seguro->porcentaje == 0) $ @endif
							{{ $seguro->valor }} / {{ $seguro->pago }}
							@if($seguro->porcentaje == 1) % @endif
						</span>
					</td>
					<td>
						<span>{{ $seguro->valor_cobertura }} / {{ $seguro->unidad_cobertura }}</span>
					</td>
					<td>
						<span>{{ $seguro->aseguradora }}</span>
					</td>
					<td>
						<span>
							@if($seguro->estado == 1) Público @endif
							@if($seguro->estado == 0) Privado @endif
						</span>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
		<p>Esta categoría aún no tiene seguros asignados</p>
		@endif --}}
		<!-- Meanwhile attributes are not stored -->
		<p>Este seguro aún no tiene atributos asignados</p>
	</div>
</div>

@stop