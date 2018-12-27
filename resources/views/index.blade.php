<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Admin</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
</div>
        <div class="container">
            <div class="content">
                <div class="title m-b-md">
                   Biblioteca
                </div>

                {{--<div class="links">--}}
                    {{--<a href="https://laravel.com/docs">Documentation</a>--}}
                    {{--<a href="https://laracasts.com">Laracasts</a>--}}
                    {{--<a href="https://laravel-news.com">News</a>--}}
                    {{--<a href="https://nova.laravel.com">Nova</a>--}}
                    {{--<a href="https://forge.laravel.com">Forge</a>--}}
                    {{--<a href="https://github.com/laravel/laravel">GitHub</a>--}}
                {{--</div>--}}

                <div class="col">
                    <form method="get">
                        <div class="form-group">
                            <label for="Buscar libro">Buscar libro</label>
                            <input type="text" name="q" value="{{ $request->q }}" required class="form-control col-12">
                            <br>
                            <button type="submit" class="btn btn-primary pull-right">Buscar</button>
                            <a href="/"  class="btn btn-primary pull-right">Limpiar</a>
                        </div>
                    </form>
                    @include('alert')
                </div>



                <div class="text-left">
                    <table class="table table-striped table-hover" width="100%">
                       <thead>
                       <tr>
                           <th>Titulo</th>
                           <th>Autor(es)</th>
                           <th>Volumen</th>
                           <th>Calif. media</th>
                           <th>Calificar</th>
                       </tr>
                       </thead>

                        <tbody>
                            @foreach($data as $file)
                                <tr>
                                    <td>{{ $file->titulo }}</td>
                                    <td>{{ $file->autor1 }} {{ $file->autor2 }}</td>
                                    <td width="10px text-center">{{ $file->volumen }}</td>
                                    <td width="10px text-center"></td>
                                    <td width="30px text-center">
                                        @if($busqueda_id > 0)
                                        {!! Form::open(['route'=>'calificar', 'method'=>'POST']) !!}
                                        <input type="hidden" value="{{ $file->id }}" name="libro_id">
                                        <input type="hidden" value="{{ $busqueda_id }}" name="busqueda_id">


                                        <select name="ranking" id="ranking">
                                            @for($i=1; $i<=5; $i++)
                                                <option onchange="submit.this()"  value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Cal</button>

                                        {!! Form::close() !!}
                                        @endif
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
        </div>
    </body>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
</html>
