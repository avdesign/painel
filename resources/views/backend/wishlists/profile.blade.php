<div class="block">
    <div class="with-padding">
        <h4 class="blue underline">{{$data->profile->name}}</h4>
        <ul class="bullet-list">
            @if($data->profile_id == 3)
                <li>Nome Fantasia: <strong> {{$data->first_name}} </strong></li>
                <li>Razão Social: <strong> {{$data->last_name}} </strong></li>
                <li>CNPJ: <strong> {{$data->document1}} </strong></li>
                <li>Inscrição Estadual: <strong> {{$data->document2}} </strong></li>
            @else
                <li>Nome: <strong> {{$data->first_name}} {{$data->last_name}}</strong></li>
                <li>CPF: <strong> {{$data->document1}} </strong></li>
                <li>RG: <strong> {{$data->document2}} </strong></li>
            @endif
            <li>Email: <strong> {{$data->email}} </strong></li>
            <li>Telefone: <strong> {{$data->phone}} </strong></li>
            <li>Celular: <strong>  {{$data->phone}} </strong></li>

        </ul>
    </div>
</div>

