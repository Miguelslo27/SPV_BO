@extends('layouts.master')

@section('content')

<h1>Seguro deseas eliminar la categoría "{{ $categoria->nombre }}?"</h1>

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
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['categorias.destroy', $categoria->id]
            ]) !!}
                {!! Form::submit('Eliminar definitivamente', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel-body">
        <p>Estás a punto de eliminar una categoría por completo, si confirmas no podrás recuperarla.</p>
    </div>
</div>

@stop