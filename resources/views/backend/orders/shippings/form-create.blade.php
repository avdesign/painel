<div id="modal-order-shippings">
    <form id="form-order-shippings-{{$order_id}}" method="POST" action="{{route('order-shippings.store', $order_id)}}" onsubmit="return false">
        @csrf
        <fieldset class="fieldset">
            <legend class="legend">Método de envio</legend>
            <p class="button-height inline-label">
                <label for="config_shipping_id" class="label">Método <span class="red">*</span></label>
                <select name="config_shipping_id" class="select">
                    <option value=""> Selecione Um </option>
                    @foreach($options as $key => $val)
                        <option value="{{$key}}"> {{$val}} </option>
                    @endforeach
                </select>
            </p>
            <p class="button-height inline-label">
                <label for="status" class="label">Status <span class="red">*</span></label>
                <select name="status" class="select">
                    <option value="Aguardando"> Aguardando </option>
                    <option value="Enviado"> Enviado </option>
                    <option value="Postado"> Postado </option>
                    <option value="Retirado"> Retirado </option>
                </select>
                <span class="info-spot">
                    <span class="icon-info-round"></span>
                    <span class="info-bubble">Aguardando:Na Loja<br>Enviado:Transportadora<br>Postado: Correio<br>Retirado:Pelo cliente na loja</span>
                </span>
            </p>
            <p class="button-height inline-label">
                <label for="date_send" class="label"> Data </label>
                <input type="date" name="date_send" class="input" value="">
            </p>

        </fieldset>
        <fieldset id="tracking" class="fieldset">
            <legend class="legend">Pelo Correio</legend>
            <p class="button-height block-label">
                <label for="code" class="label"> Código <span class="red">*</span>
                    <small>Rastreamento</small>
                </label>
                <input type="text" name="code" class="input full-width" value="">
            </p>
            <p class="button-height block-label">
                <label for="url" class="label"> Link <span class="red">*</span>
                    <small>Link Rastreamento</small>
                </label>
                <input type="text" name="url" class="input full-width" value="">
            </p>
        </fieldset>

        <fieldset id="shipping-company" class="fieldset">
            <legend class="legend">Por Transportadora</legend>
            <p class="button-height block-label">
                <label for="name" class="label"> Nome <span class="red">*</span>
                    <small>Transportadora</small>
                </label>
                <input type="text" name="name" class="input full-width" value="">
            </p>
            <p class="button-height block-label">
                <label for="name" class="label"> Telefone <span class="red">*</span>
                    <small>Telefone</small>
                </label>
                <input type="text" name="phone" class="input full-width" value="">
            </p>
        </fieldset>

        <p class="button-height block-label">
            <label for="input" class="label"> Observação: </label>
            <textarea rows="2" name="note" class="input full-width"></textarea>
        </p>
        <p class="button-height align-center">
            <span class="button-group">
                <button onclick="fechaModal()" class="button"> Cancelar </button>
                @can('orders-create')
                    <button id="btn-modal" onclick="formOrderNote('order-shippings-{{$order_id}}', '{{$order_id}}','{{route('order-shippings.show', ['order_id' => $order_id, 'id' => 'new'])}}')" class="button blue-gradient">
                        <span class="icon-publish"></span> Salvar
                    </button>
                @endcan
            </span>
        </p>
    </form>
</div>