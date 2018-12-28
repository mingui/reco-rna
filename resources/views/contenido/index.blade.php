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
            <a href="{{ route($ruta.'.create') }}" class="btn btn-primary  pull-right"><i class="fa fa-plus"></i>Nuevo</a>
        </div>
        <div class="box-body">
            <table class="table table-striped">
                <tr>
                <th>ID</th>
                <th>TEMAS</th>
                <th width="50px"><i class="fa fa-gear"></i></th>
                </tr>

                <tbody>
                @foreach($data as $file)
                    <tr>
                        <td>{{ $file->id }}</td>
                        <td>{{ $file->tema }}</td>
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
