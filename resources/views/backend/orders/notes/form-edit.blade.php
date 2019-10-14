<div id="modal-order-notes">
    <form id="form-order-notes-{{$order_id}}" method="POST" action="{{route('order-notes.update', ['order_id' => $order_id, 'id' =>$data->id])}}" onsubmit="return false">
        @method("PUT")
        @csrf
        <p class="button-height block-label">
            <label for="input" class="label"> Observação <span class="red">*</span></label>
            <textarea rows="8" name="description" class="input full-width">{{$data->description}}</textarea>
        </p>
        <p class="button-height align-center">
            <span class="button-group">
                <button onclick="fechaModal()" class="button"> Cancelar </button>
                @can('orders-update')
                    <button id="btn-modal" onclick="formOrderNote('order-notes-{{$order_id}}', '{{$order_id}}','{{route('order-notes.show', ['order_id' => $order_id, 'id' => $data->id])}}')" class="button blue-gradient">
                        <span class="icon-publish"></span> Alterar
                    </button>
                @endcan
            </span>
        </p>
    </form>
</div>

