<div id="modal-contents">
    <form id="form-contents" method="POST" action="{{route('faqs.update', $data->id)}}" onsubmit="return false">
        <input type="hidden" name="type" value="{{$data->type}}">
        <input type="hidden" name="order" value="{{$data->order}}">
        <input type="hidden" name="active" value="{{$data->active}}">
        @method('PUT')
        @csrf
        <fieldset class="fieldset">
            <p class="block-label button-height">
                <label for="question" class="label">Pergunta <span class="red">*</span></label>
                <input type="text" name="question" class="input full-width" value="{{$data->question}}">
            </p>
            <p class="button-height inline-label">
            </p>
            <p class="button-height block-label">
                <label for="response" class="label"> Descrição <span class="red">*</span></label>
                <textarea id="faqs-edit" rows="15" name="response" class="input full-width">{!! $data->response !!}</textarea>
            </p>

            <p class="button-height align-center">
                <span class="button-group">
                    <button onclick="fechaModal()" class="button"> Cancelar </button>
                    @can('contents-site-create')
                        <button id="btn-modal" onclick="formContents('update', 'contents', '{{route('faqs.load')}}')" class="button blue-gradient">
                        <span class="icon-publish"></span> Alterar
                    </button>
                    @endcan
                </span>
            </p>
        </fieldset>
    </form>
</div>
