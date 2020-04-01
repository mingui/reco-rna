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
           
               @include('includes.inc_buscador')
               <a href="{{ route($ruta.'.create') }}" class="btn btn-primary  pull-right"><i class="fa fa-plus"></i>Nuevo</a>
               <a href="{{ route($ruta.'.index') }}" class="btn btn-default  pull-right"><i class="fa fa-refresh"></i></a>

        </div>
        <div class="box-body">
            <table class="table table-striped">
                <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>SEMESTRE</th>
                <th>PLAN DE ESTUDIO</th>
                <th>TEMAS</th>
                <th width="50px"><i class="fa fa-gear"></i></th>
                </tr>

                <tbody>
                @foreach($data as $file)
                    <tr>
                        <td>{{ $file->id }}</td>
                        <td>{{ $file->nombre }}</td>
                        <td>{{ $file->semestre }}</td>
                        <td>{{ $file->planes->plan }}</td>
                        <td>
                            <div class="btn-group">
                            <a href="/asigc/{{$file->id}}" class="fa fa-book"></i> </a>
                                
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route($ruta.'.edit', $file->id) }}"><i class="fa fa-edit"></i> </a>
                                <a href="{{ route($ruta.'.show', $file->id) }}"><i class="fa fa-remove"></i> </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="text-center">
                {!! $data->links()  !!}
            </div>
        </div>

</div>

@stop
