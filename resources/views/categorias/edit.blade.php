@extends('layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/bootstrap-iconpicker.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/iconset/iconset-fontawesome-4.3.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-iconpicker.min.js') }}"></script>
@endpush

@section('content')

<h1><span class="glyphicon glyphicon-pencil"></span> Editando categoría "{{ $categoria->nombre }}"</h1>
<p class="lead">Edita esta categoría o vuelve a la lista. <a href="{{ route('categorias.index') }}">Volver a la lista.</a></p>

<hr>

@include('partials.alerts.errors')
@include('partials.alerts.success-message')

{!! Form::model($categoria, [
    'method' => 'PATCH',
    'route' => ['categorias.update', $categoria->id]
]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="{{ route('categorias.index') }}" class="btn btn-info">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Atrás
            </a>

            <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-floppy-disk"></span>
                Guardar cambios
            </button>
            
            <div class="pull-right">
                <a href="{{ route('categorias.delete', $categoria->id) }}" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove"></span>
                    Eliminar Categoría
                </a>
            </div>
        </div>

        <div class="panel-body">
            <div class="form-group">
                {!! Form::label('nombre', 'Nombre:', ['class' => 'control-label']) !!}
                {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('caracteristicas', 'Características:', ['class' => 'control-label']) !!}
                <p><small>Escribe las características separadas por coma: <em><strong>Ejemplo 1, ejemplo 2</strong></em></small></p>
                <p><small>Para agregar segunda línea a una característica, escribe entre paréntesis rectos: <em>Ejemplo 1 <strong>[Segunda línea]</strong>, Ejemplo 2</em></small></p>
                {!! Form::text('caracteristicas', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('icono', 'Ícono:', ['class' => 'control-label']) !!}
                
                &nbsp;
                <button
                 data-iconset="fontawesome"
                 data-icon="{{ $categoria->icono }}"
                 data-search-text="Buscar..."
                 data-cols="6"
                 data-placement="top"
                 data-unselected-class="btn-info"
                 class="btn btn-success btn-lg"
                 id="icono"
                 name="icono"
                 class="form-control"
                 type="text"
                 role="iconpicker">
                </button>

                &nbsp;
                <label>Estado: </label>
                <input type="checkbox" id="estado" name="estado" {{ $categoria->estado ? 'checked=""' : '' }}>
                <label for="estado">&nbsp;</label>
            </div>
        </div>

        <div class="panel-footer">
            <button type="submit" class="btn btn-primary">
                <span class="glyphicon glyphicon-floppy-disk"></span>
                Guardar cambios
            </button>
        </div>
    </div>

{!! Form::close() !!}

@stop