<div class="block">
    <div class="with-padding">
        <h4 class="blue underline">Perfil do Fabricante</h4>
            <p>Nome: <strong> {{$data->name}} </strong></p>
            <p>Visitas: <strong> {{$data->visits}} </strong></p>
            <p>Descrição: <strong> {{$data->description}} </strong></p>
            <p>Tags: <strong> {{$data->tags}} </strong></p>
            <p>Status Logo:  {{$data->active_logo}}</p>
            <p>Status Banner:  {{$data->active_banner}}</p>
            @if($configModel->info == 1)
                <p>Email: <strong> {{$data->email}} </strong></p>
                <p>Telefone: <strong> {{$data->phone}} </strong></p>
                <p>Endereço: <strong> {{$data->address}}, {{$data->number}}</strong></p>
                <p>Bairro: <strong> {{$data->district}} </strong></p>
                <p>Cidade: <strong> {{$data->city}} - {{$data->state}}</strong></p>
                <p>CEP: <strong>{{$data->zip_code}}</strong> </p>
            @endif
        </ul>
    </div>
</div>



