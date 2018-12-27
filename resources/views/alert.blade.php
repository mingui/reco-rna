<div class="col-md-12">    <div class="text-center">        @if ($message = Session::get('success'))            <div class="alert alert-success">                <button type="button" class="close" data-dismiss="alert" aria-label="Close">                    <span aria-hidden="true">&times;</span>                </button>                <p>{!! $message !!}</p>            </div>        @endif        @if ($message = Session::get('warning'))            <div class="alert alert-warning">                <button type="button" class="close" data-dismiss="alert" aria-label="Close">                    <span aria-hidden="true">&times;</span>                </button>                <p>{!! $message !!}</p>            </div>        @endif        @if ($message = Session::get('danger'))            <div class="alert alert-danger">                <button type="button" class="close" data-dismiss="alert" aria-label="Close">                    <span aria-hidden="true">&times;</span>                </button>                <p>{!! $message !!}</p>            </div>        @endif        @if (count($errors) > 0)            <div class="alert alert-danger">                <strong>Whoops!</strong> Hubo algunos problemas con su entrada.<br><br>                <ul>                    @foreach ($errors->all() as $error)                        <li>{{ $error }}</li>                    @endforeach                </ul>            </div>        @endif    </div></div>