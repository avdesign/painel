<div class="block margin-bottom">
    <div class="block-title">
        <h3>
            <span class="icon-bag"></span> {{$title}}</span>
        </h3>
        <div class="button-group absolute-right compact">
            <button onclick="abreModal('Adicionar Produto', '{{route('order-items.products', $order->id)}}', 'products', 2, 'true', 500, 600);" title="Adicionar Produto" class="button icon-plus-round blue-gradient">Adicionar</button>
        </div>
    </div>

    <div class="block">
        <div class="with-padding spaced silver-gradient" id="list-{{$order->id}}">
            @forelse($items as $item)
                <div class="columns" id="order-item-{{$item->id}}">
                    <p class="underline"></p>
                    <div class="two-columns">
                        <img src="{{url($photo_url.$image->path.$item->image)}}">
                    </div>

                    <div class="five-columns">
                        <p class="inline-label"><strong>Cor:</strong> {{$item->color}}</p>
                        @if($item->kit == 1)
                            <p class="button-height inline-label"><strong>{{$item->kit_name}} {{$item->unit}} {{$item->measure}}</strong> {{$item->grid}}</p>
                        @else
                            <p class="button-height inline-label"><strong>N&deg;:</strong> {{$item->grid}}</p>
                        @endif
                        <p class="button-height inline-label"><strong>Qtd:</strong> {{$item->quantity}}</p>
                    </div>

                    <div class="five-columns align-right">
                        <div class="button-group compact">
                            <button onclick="deleteOrderItem('order-item-{{$item->id}}', '{{route('order-items.destroy', ['id' => $item->id,'order' => $item->order_id])}}');" class="button icon-trash with-tooltip red-gradient" title="Excluir"></button>
                            <button onclick="abreModal('Editar Quantidade', '{{route('order-items.edit', ['order_id' => $order->id,'id' => $item->id])}}', 'order-item-{{$item->id}}', 2, 'true', 390, 100);" class="button icon-pencil">Editar</button>
                        </div>
                        <p class="margin-top"><strong>À Vista:</strong> {{setReal($item->price_cash)}}</p>
                        <p><strong>No Cartão:</strong> {{setReal($item->price_card)}}</p>
                    </div>
                </div>
            @empty
                <p><strong>Esta lista está vazia!</strong></p>
            @endforelse
        </div>
    </div>

</div>
