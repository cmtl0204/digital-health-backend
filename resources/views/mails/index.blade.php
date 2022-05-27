<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$system->acronym}}</title>
    <style>

    </style>
</head>
<body>
<div class="content">
    <div class="row">
        <div class="col-7 offset-2">
            <img
                src="{{$message->embed(asset('images/email/logo.png'))}}"
                width="120px"
                height="100px"
                alt="Imagen PNG alternativa">
        </div>
    </div>
    <div class="row">
        <div class="col-6 offset-2 border">
            <p class="text-muted">
                Fecha: <b>{{\Carbon\Carbon::now()->toDateString()}}</b>
                <b class="ml-2">{{\Carbon\Carbon::now()->toTimeString()}}</b>
            </p>
            <p class="text-muted">
                Hola, <b>{{$data->user->name}} {{$data->user->lastname}}</b>
            </p>
            <br>
            @yield('content')
            <br>
            <p>
                Saludos cordiales
            </p>
        </div>
    </div>
</div>
</body>
</html>
