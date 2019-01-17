<?php
/**
 * Created by PhpStorm.
 * User: gnumux
 * Date: 12/22/18
 * Time: 5:42 PM
 */
 ?>

@extends('adminlte::page')

@section('title',  $title )

@section('content_header')
    <h1>{{$title}}</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>
            <a href="{{ route($ruta.'.index') }}" class="btn btn-primary  pull-right"><i class="fa fa-list"></i> Volver</a>
        </div>
        <div class="box-body">
            {{ Form::model($data, ['route' => [$ruta.'.update', $data->id], 'method' => 'patch']) }}

            <div class="form-group col-xs-6">
            {!!Form::label('Libro')!!}
                {!! Form::select('bibliografia_id', $titulo, null, ['class'=> 'form-control'])  !!}
            </div>


            <div class="form-group col-xs-6">
            {!!Form::label('Tema')!!}
                {!! Form::select('contenido_id', $tema, null, ['class'=> 'form-control'])  !!}
            </div>


            <div class="clearfix"></div>
            {!!Form::submit('Guardar',['id'=>'guardar','content'=>'<span>Continuar</span>', 'class'=>'btn btn-primary btn-sm'])!!}
            {!! Form::close() !!}

        </div>





    </div>

@stop
