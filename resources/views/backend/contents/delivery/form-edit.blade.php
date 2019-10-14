<div id="modal-contents">
    <form id="form-contents" method="POST" action="{{route('delivery.update', $data->id)}}" onsubmit="return false">
        <input type="hidden" name="type" value="{{$data->type}}">
        <input type="hidden" name="order" value="{{$data->order}}">
        <input type="hidden" name="active" value="{{$data->active}}">
        @method('PUT')
        @csrf
        <fieldset class="fieldset">
            <p class="block-label button-height">
                <label for="title" class="label">Titulo <small>Caixa Alta (max 255 chars) </small></label>
                <input type="text" name="title" class="input full-width" value="{{$data->title}}">
            </p>
            <p class="button-height inline-label">
            </p>
            <p class="button-height block-label">
                <label for="description" class="label"> Descrição <span class="red">*</span></label>
                <textarea id="delivery-edit" rows="15" name="description" class="input full-width">{!! $data->description !!}</textarea>
            </p>

            <p class="button-height align-center">
                <span class="button-group">
                    <button onclick="fechaModal()" class="button"> Cancelar </button>
                    @can('contents-site-create')
                        <button id="btn-modal" onclick="formContents('update', 'contents', '{{route('delivery.load')}}')" class="button blue-gradient">
                        <span class="icon-publish"></span> Alterar
                    </button>
                    @endcan
                </span>
            </p>
        </fieldset>
    </form>
</div>
