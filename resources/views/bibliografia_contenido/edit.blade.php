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

            <div class="clear"></div>
            <hr>

            <div class="col-md-6">
                <h2>No asignados</h2>
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>ID</td>
                        <td>NOMBRE</td>
                        <td></td>
                    </tr>
                    @foreach($temas as $file)
                        <tr>
                            <td>{{ $file->id}}</td>
                            <td>{{ $file->tema }}</td>
                            <td><a href="/bibliografia_contenido_add/{{$file->id}}/{{$data->id}}" class="btn btn-default btn-xs btn-success"><i class="fa fa-arrow-right"></i></a></td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="col-md-6">
                <h2>Asignados</h2>
                <table class="table table-bordered table-hover">
                    <tr>
                        <td></td>
                        <td>ID</td>
                        <td>NOMBRE</td>

                    </tr>
                    @foreach($bibliografia_contenido as $file)
                        <tr>
                            <td><a href="/bibliografia_contenido_remove/{{$file->id}}" class="btn btn-default btn-xs btn-danger"><i class="fa fa-arrow-left"></i></a></td>
                            <td>{{ $file->id}}</td>
                            <td>{{ get_nombre_contenido($file->contenido_id) }}</td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>





</div>

@stop
