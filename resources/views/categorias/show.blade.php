@extends('layouts.master')

@section('content')

<h1>{{ $categoria->nombre }}</h1>

<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success-message')

<div class="panel panel-default">
	<div class="panel-heading">
		<a href="{{ route('categorias.index') }}" class="btn btn-info">
			<span class="glyphicon glyphicon-chevron-left"></span>
			Atrás
		</a>

		<a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-info">
			<span class="glyphicon glyphicon-pencil"></span>
			Editar
		</a>

		<div class="pull-right">
            <a href="{{ route('categorias.delete', $categoria->id) }}" class="btn btn-danger">
                <span class="glyphicon glyphicon-remove"></span>
                Eliminar Categoría
            </a>
        </div>
	</div>

	<div class="panel-body">
		<p>{{ $categoria->caracteristicas }}</p>
	</div>
</div>

<hr>

<h3>Seguros en la categoría</h3>
<div class="panel panel-default">
	<div class="panel-body">
		@if(count($categoria->seguros))
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
		@endif
	</div>
</div>

@stop