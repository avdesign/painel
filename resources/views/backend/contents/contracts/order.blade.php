<p class="button-height align-center" id="tooltip-"{{$id}}>
    <span class="number input margin-left" >
        <button type="button" class="button number-down">-</button>
        <input type="text" id="input-order-{{$id}}" value="{{$order}}" size="2" name="order" class="input-unstyled" style="width:40px">
        <button type="button" class="button number-up">+</button>
    </span>
    <button type="button" onclick="updateOrder('{{$id}}','{{route('contract.order', $id)}}', '{{csrf_token()}}')" class="button blue-gradient display-none">Alterar</button>
</p>