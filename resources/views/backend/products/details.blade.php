<div class="block">
    <div class="with-padding">
        <h4 class="blue underline">Perfil do Produto</h4>
        <p>Nome: <strong> {{$data->name}} </strong></p>
        <p>Descrição: <strong> {{$data->description}} </strong></p>
        <p>Tags: <strong> {{$data->tags}} </strong></p>
        @if($configProduct->cost == 1)
            @php
                $cost = $data->cost;
            @endphp
            <p>Custo: <strong> {{setReal($cost->value)}} </strong></p>
        @endif
        @if($configProduct->stock == 1)
            <p>Estoque: <strong> {{$stock}} </strong></p>
        @endif
        @if($configProduct->kit == 1)
            <p>Kit: <strong>  {{$data->kit_name}}</strong></p>
        @endif
        <p>Unidade Medida: <strong>  {{$data->unit}} {{$data->measure}}</strong></p>

        @foreach($prices as $price)

            @php
                ($price->profile != $configProduct->price_default ? $price_card_percent = $price->sum_card.round($price->price_cash_percent, 2).'%' : $price_card_percent = '');
            @endphp
            <p><small class="tag">{{$price->profile}}</small> À Vista: {{$price->sum_cash}}{{round($price->price_cash_percent, 2)}}%<strong>&nbsp;&nbsp;{{setReal($price->price_cash)}}</strong>&nbsp;&nbsp; - &nbsp;&nbsp;Parcelado: {{$price_card_percent}}<strong>&nbsp;&nbsp;{{setReal($price->price_card)}}</strong></p>
            @if($data->offer == 1)
            <p><small class="tag green-bg">{{$price->profile}}</small> Oferta à Vista: {{round($price->offer_percent, 2)}}%<strong>&nbsp;&nbsp;{{setReal($price->offer_cash)}}</strong>&nbsp;&nbsp; - &nbsp;&nbsp;Parcelado: <strong>{{setReal($price->offer_card)}}</strong></p>
            @endif
        @endforeach

        @if($configProduct->freight == 1)
            @if($configFreight->weight == 1)
                <p>Peso: <strong> {{$data->weight}} Kg</strong></p>
            @endif
            @if($configFreight->height == 1)
                <p>Altura: <strong> {{$data->height}} cm</strong></p>
            @endif
            @if($configFreight->width == 1)
                <p>Largura: <strong> {{$data->width}} cm</strong></p>
            @endif
            @if($configFreight->length == 1)
                <p>Comprimento: <strong> {{$data->length}} cm</strong></p>
            @endif
        @endif
        @if($configProduct->video == 1)
            <p>Video: <strong> {{$data->video}} </strong></p>
        @endif
    </div>
</div>