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

            <div class="form-group col-xs-5">
                {!!Form::label('Titulo')!!}
                {!!Form::text('titulo',null,['id'=>'titulo','class'=>'form-control ', 'required'])!!}
            </div>

            <div class="form-group col-xs-5">
                {!!Form::label('Autor 1')!!}
                {!!Form::text('autor1',null,['id'=>'autor1','class'=>'form-control ', 'required'])!!}
            </div>

            <div class="form-group col-xs-5">
                {!!Form::label('Autor 2')!!}
                {!!Form::text('autor2',null,['id'=>'autor2','class'=>'form-control ', 'required'])!!}
            </div>

            <div class="form-group col-xs-2">
                {!!Form::label('Volumen')!!}
                {!!Form::number('volumen',null,['id'=>'volumen','class'=>'form-control ', 'required'])!!}
            </div>


            <div class="clearfix"></div>
            {!!Form::submit('Guardar',['id'=>'guardar','content'=>'<span>Continuar</span>', 'class'=>'btn btn-primary btn-sm'])!!}
            {!! Form::close() !!}
        </div>

</div>

@stop
