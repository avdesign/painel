<div id="modal-order-items">
    <form id="form-order-items-{{$data->id}}" method="POST" action="{{route('order-items.update', ['id' =>$data->id, 'order_id' => $data->order_id])}}" onsubmit="return false">
        <input name="_method" type="hidden" value="PUT">
        {{csrf_field()}}
        @if($data->kit == 1)

            <p class="button-height align-center">
                <span class="input">
                    <label for="kit-{{$data->id}}" class="button silver-gradient"> {{$data->kit_name}} {{$data->unit}} {{$data->measure}} </label>
                    <label for="quantity-{{$data->id}}" class="button blue-gradient"> {{$data->grid}} </label>
                    <input type="text" id="quantity-{{$data->id}}" name="quantity" class="input-unstyled" placeholder="Qtd" value="{{$data->quantity}}" autocomplete="off" style="width: 30px;">
                </span>
            </p>

        @else

            <p class="button-height">
                <span class="input">
                    <label for="quantity-{{$data->id}}" class="button blue-gradient"> {{$data->grid}} </label>
                    <input type="text" id="quantity-{{$data->id}}" name="quantity" class="input-unstyled" placeholder="Qtd" value="{{$data->quantity}}" autocomplete="off" style="width: 30px;">
                </span>
            </p>

        @endif
        @can('orders-update')
            <p class="button-height align-center">
                <span class="button-group">
                    <button onclick="fechaModal()" class="button"> Cancelar </button>
                    <button id="btn-modal-{{$data->id}}" onclick="updateOrderItem('form-order-items-{{$data->id}}', '{{$data->id}}', '{{$data->order_id}}','{{route('order-items.reload', $data->order_id)}}')" class="button icon-publish blue-gradient"> Salvar </button>
                </span>
            </p>
        @endcan
    </form>
</div>

