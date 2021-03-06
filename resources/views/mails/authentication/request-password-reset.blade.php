@extends('mails.index')
@section('content')
    <div class="row">
        <div class="col-12 text-muted ">
            <h3 class="text-center">Restablecimiento de contraseña</h3>
            <br>
            <p>Recibimos una solicitud de restablecimiento de contraseña para su cuenta.
            </p>
            <br>
            <p>Este código tiene tiempo de duración de <b>10 min.</b> y es válido por <b>una sola ocasión</b>.</p>
            <br>
            <h2>Código: <b>{{$data->token}}</b>
            </h2>
            <br>
            <p>Si no ha solicitado este servicio, repórtelo al administrador.</p>
        </div>
    </div>
@endsection
