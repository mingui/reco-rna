<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css">

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
            <a href="{{ url('/') }}">Biblioteca</a>
            <a href="{{ url('/libros_user') }}">Mis libros</a>
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
           Mis libros
        </div>



        <div class="text-left">
            <table class="table table-striped table-hover" width="100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Autor(es)</th>
                    <th>Volumen</th>
                    <th>Calif. media</th>
                </tr>
                </thead>

                <tbody>
                @foreach(retornarSugerencias() as $file)
                        <tr class="alert-success">
                                    <td>{{ $file[1] }}</td>
                                    <td>{{ getLibroData($file[1])->titulo }}

                                    <span class="label alert-success pull-right">{{ number_format($file[2], 2) }}</span>

                                    </td>
                                    <td>{{ getLibroData($file[1])->autor1 }} {{ getLibroData($file[1])->autor2 }}</td>
                                    <td width="10px text-center">{{ getLibroData($file[1])->volumen }}</td>
                                    <td width="10px text-center">
                                        {{ get_ranking_medio($file[1]) }}

                                    </td>
                                    <td width="30px text-center">
                                        @if(auth()->user())
                                        @if(in_array($file[1], userLibrosInArray()))
                                            <button  class="btn btn-success btn-sm disabled"><i class="fa fa-heart"></i></button>
                                        @else
                                            @if(session()->get('busqueda_id') > 0 && $request->q)
                                                {!! Form::open(['route'=>'libro_add', 'method'=>'GET']) !!}
                                                <input type="hidden" value="{{ $file->id }}" name="libro_id">
                                                <input type="hidden" value="{{ session()->get('busqueda_id') }}" name="busqueda_id">
                                                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-heart"></i></button>
                                                {!! Form::close() !!}
                                            @endif
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                          
                </tbody>

            </table>
            <div class="text-center">
               
            </div>
        </div>
    </div>
</div>
</body>

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
</html>
