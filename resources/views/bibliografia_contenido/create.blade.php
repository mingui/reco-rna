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
            {!! Form::open(['route'=>$ruta.'.store', 'method'=>'POST']) !!}


            <div class="form-group col-xs-5">
            {!!Form::label('Bibliografia')!!}
                {!!Form::text('titulo',null,['id'=>'bibliografia_id','class'=>'form-control ', 'required'])!!}
            </div>


            <div class="form-group col-xs-2">
            {!!Form::label('Tema')!!}
                {!!Form::text('tema',null,['id'=>'contenido_id','class'=>'form-control ', 'required'])!!}
            </div>

        

            <div class="clearfix"></div>
            {!!Form::submit('Guardar',['id'=>'guardar','content'=>'<span>Continuar</span>', 'class'=>'btn btn-primary btn-sm'])!!}


            {!! Form::close() !!}
        </div>

</div>

@stop
