@extends('layouts.master')

@section('content')

<h1>Seguro deseas eliminar el atributo "{{ $atributo->nombre }}"?</h1>

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
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['atributos.destroy', $atributo->id]
            ]) !!}
                {!! Form::submit('Eliminar definitivamente', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel-body">
        <p>Estás a punto de eliminar un atributo por completo, si confirmas no podrás recuperarlo.</p>
        <p>Se perderan las dependencias con los seguros asociados.</p>
    </div>
</div>

@stop