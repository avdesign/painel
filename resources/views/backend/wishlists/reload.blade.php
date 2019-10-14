@forelse($data as $item)
    <li id="wishlist-item-{{$item->id}}">
        <img src="{{url($image->path.$item->image)}}">
        <div class="small-margin-top">
            <strong>Cor:</strong> {{$item->color}}
            @if($item->kit == 1)
                <strong>{{$item->kit_name}} {{$item->unit}} {{$item->measure}}</strong> {{$item->grid}}
            @else
                <strong>N&deg;:</strong> {{$item->grid}}
            @endif
            <strong>Qtd:</strong> {{$item->quantity}}<br>
        </div>
        <div class="button-group absolute-right">
            <button onclick="abreModal('Editar Quantidade', '{{route('lista-desejos.edit', $item->id)}}', 'product', 2, 'true', 390, 100);" class="button icon-pencil">Editar</button>
            <button onclick="deleteWiswlistProduct('wishlist-item-{{$item->id}}', '{{route('lista-desejos.destroy', $item->id)}}')" class="button icon-trash with-tooltip" title="Excluir"></button>
        </div>
    </li>
@empty
    <li><strong>Esta lista está vazia!</strong></li>
@endforelse