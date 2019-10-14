<div class="block margin-bottom">

    <div class="block-title">
        <h3>
            <span class="icon-heart-empty icon-size2" aria-hidden="true"></span>
        </h3>
        <div class="button-group absolute-right compact">
            <button onclick="abreModal('Adicionar Produto', '{{route('wishlist.products', $user->id)}}', 'products', 2, 'true', 500, 600);" title="Adicionar Produto" class="button icon-plus-round">Adicionar</button>
            <button onclick="reloadWishlist('{{$user->id}}', '{{route('wishlist.reload', $user->id)}}')" title="Atualizar" class="button icon-redo"></button>
            <button onclick="saveWishlist('{{$user->id}}', '{{route('wishlist.save', $user->id)}}')" title="Fechar" class="button icon-publish blue-gradient">Salvar</button>
        </div>
    </div>

    <div class="block">
        <ul class="with-padding list spaced silver-gradient" id="list-{{$user->id}}">
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
        </ul>
    </div>

</div>






