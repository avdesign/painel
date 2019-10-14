<div class="block">
    <div class="with-padding">
<div class="columns">
    <div class="six-columns">
        <h4 class="blue underline">Perfil: {{$user->profile->name}}</h4>
        @if ($data->user->type_id == 1)
            <p>Nome Fantasia: <strong> {{$user->first_name}} </strong></p>
            <p>Razão Social: <strong> {{$user->last_name}} </strong></p>
            <p>CNPJ: <strong> {{$user->document1}} </strong></p>
            <p>Inscrição Estadual: <strong> {{$user->document2}} </strong></p>
        @else
            <p>Nome: <strong> {{$user->first_name}} {{$user->last_name}} </strong></p>
            <p>CPF: <strong> {{$user->document1}} </strong></p>
            <p>RG: <strong> {{$user->document2}} </strong></p>
        @endif
        <p>Email: <strong> {{$user->email}} </strong></p>
        <p>WhatsApp: <strong> {{$user->cell}} </strong></p>
        <p>Telefone: <strong> {{$user->phone}} </strong></p>

        @if ($address->delivery == 1)
            <h4 class="blue underline">Endereço de Entrega</h4>
            <p>Endereço: <strong> {{$address->address}}, {{$address->number}}</strong></p>
            <p>Complemento: <strong> {{$address->complement}}</strong></p>
            <p>Bairro: <strong> {{$address->district}}</strong></p>
            <p>Cidade: <strong> {{$address->city}}</strong></p>
            <p>Estado: <strong> {{$address->state}}</strong></p>
            <p>CEP: <strong> {{$address->zip_code}}</strong></p>
            <p>IP: <strong> {{$data->ip}}</strong></p>
        @else
            <h4 class="red underline">Não há endereço de entrega </h4>
        @endif
    </div>
    <div class="six-columns">
        <h4 class="blue underline">Pedido: {{$data->reference}}</h4>
        @if ($data->company == 'PagSeguro')
            <p>Status: <strong> {{config('pagseguro.status.'.$data->config_status_payment_id.'.label')}} </strong></p>
            <p>Gatteway: <strong> {{$data->company}} </strong></p>
        @else
            <p>Status: <strong> {{$data->configStatusPayment->label}} </strong></p>
        @endif
        <p>Pagamento: <strong> {{$data->configFormPayment->label}}  </strong></p>
        @if ($data->config_form_payment_id >=3)
            <p>No Cartão: <strong> {{setReal($data->price_card)}} </strong></p>
        @else
            <p>À Vista: <strong> {{setReal($data->price_cash)}} </strong></p>
        @endif
        <p>Desconto: <strong> {{setReal($data->discount)}} </strong></p>
        <p>Taxa: <strong> {{setReal($data->tax)}} </strong></p>
        <h4 class="blue underline">Dados do Frete</h4>
        <p>Valor: <strong> {{setReal($data->freight)}} </strong></p>
        {!! $shipping !!};

    </div>
</div>
</div>
</div>
