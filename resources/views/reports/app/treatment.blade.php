<h3 class="text-center">Se certifica que se encuentra registrado en el sistema de Bolsa de Empleo</h3>
<h1>{{$data->gender}}</h1>

<table>
    @foreach($data->treatment_results as $result)
        <tr>
            <td width="350px" class="column-left">{{$result->question->value}}</td>
            <td width="200" class="column-right">{{$result->answer->value}}</td>
        </tr>
    @endforeach
</table>
