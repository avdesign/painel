<div id="modal-wishlist">
    <form id="form-wishlist-update-{{$data->id}}" method="POST" action="{{route('lista-desejos.update', $data->id)}}" onsubmit="return false">
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
        <p class="button-height align-center">
            <span class="button-group">
                <button onclick="fechaModal()" class="button"> Cancelar </button>
                <button id="btn-modal-{{$data->id}}" onclick="updateWiswlist('form-wishlist-update-{{$data->id}}', '{{$data->id}}', '{{$data->user_id}}','{{route('wishlist.reload', $data->user_id)}}')" class="button icon-publish blue-gradient"> Salvar </button>
            </span>
        </p>

    </form>
</div>

<script>
    /**
     *
     * @param idform
     * @param id
     * @param user
     * @param reload
     */
    function updateWiswlist(idform, id, user, reload) {
        var form = $('#'+idform),
            url  = form.attr('action');
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(4,tableWishlist.txtLoader,false,'loader','btn-modal-'+id,false,'silver');
            },
            success: function(data){
                if(data.success == true){
                    reloadWishlist(user,reload);
                    msgNotifica(true, data.message, true, false);
                    fechaModal();
                } else {
                    msgNotifica(false, data.message, true, false);
                }
                setBtn(4,tableWishlist.txtSave,true,'icon-publish','btn-modal-'+id,false,'blue');
            },
            error: function(xhr){
                setBtn(4,tableWishlist.txtSave,true,'icon-publish','btn-modal-'+id,false,'blue');
                ajaxFormError(xhr);
            }
        });
    }
</script>
