@extends('layouts.master')

@section('content')

<h1>Seguro deseas eliminar el seguro "{{ $seguro->nombre }}" perteneciente a la categoría "categoría"?</h1>

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
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['seguros.destroy', $seguro->id]
            ]) !!}
                {!! Form::submit('Eliminar definitivamente', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel-body">
        <p>Estás a punto de eliminar un seguro por completo, si confirmas no podrás recuperarlo.</p>
    </div>
</div>

@stop