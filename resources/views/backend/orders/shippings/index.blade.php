<h4 class="no-margin-top">{{$title}} {{$order->id}}</h4>

<div class="large-box-shadow white-gradient with-border">

    @if(count($shippings) <= 0)
        <div class="button-height with-mid-padding silver-gradient no-margin-top">
            <span class="button-group children-tooltip">
                <button onclick="abreModal('{{$title_create}}', '{{route('order-shippings.create', $order->id)}}', 'order-shippings', 2, 'true', 500, 500);" class="button blue-gradient icon-plus-round" title="{{$title_create}}">{{$btn_create}}</button>
            </span>
        </div>
    @endif
    <div class="with-padding" id="list-order-shippings-{{$order->id}}">
        @forelse($shippings as $shipping)
            <button onclick="abreModal('{{$title_edit}}', '{{route('order-shippings.edit', ['id' => $shipping->id, 'order_id' => $order->id])}}', 'order-shippings', 2, 'true', 500, 500);" class="button blue-gradient float-right with-tooltip icon-plus-round compact" title="Mark as spam">{{$btn_edit}}</button>
            <h5 class="black">{{$shipping->configShipping->name}}</h5>
            @if(!empty($shipping->status))
                <p><strong>Status:</strong> {{$shipping->status}}</p>
            @endif
            @if(!empty($shipping->code))
                <p><strong>Código de Rastreamento:</strong> {{$shipping->code}}</p>
            @endif
            @if(!empty($shipping->url))
                <p><strong>Link do Rastreamento:</strong> {{$shipping->url}}</p>
            @endif
            @if(!empty($shipping->name))
                <p><strong>Transportadora:</strong> {{$shipping->name}}</p>
            @endif
            @if(!empty($shipping->phone))
                <p><strong>Telefone da Transportadora:</strong> {{$shipping->phone}}</p>
            @endif

            @if(!empty($shipping->note))
                    <p>Nota:{!! nl2br(e($shipping->note)) !!}</p>
                @endif
            @empty
            <div class="left-border grey">
                <p>Não existe método de envio para o pedido {{$order->id}}</p>
            </div>
        @endforelse
    </div>

</div>