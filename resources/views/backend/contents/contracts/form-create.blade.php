<div id="modal-contents">
    <form id="form-contents" method="POST" action="{{route('contract.store')}}" onsubmit="return false">
        <input type="hidden" name="type" value="content">
        @csrf
        <fieldset class="fieldset">
            <p class="block-label button-height">
                <label for="title" class="label">Titulo <small>Caixa Alta (max 255 chars) </small></label>
                <input type="text" name="title" class="input full-width" value="">
            </p>
            <p class="button-height inline-label">
            </p>
            <p class="button-height block-label">
                <label for="description" class="label"> Descrição <span class="red">*</span></label>
                <textarea id="delivery-create" rows="15" name="description" class="input full-width"></textarea>
            </p>

            <p class="button-height inline-label">
                <label for="order" class="label">Ordem / Status <span class="red">*</span></label>
                <span class="number input margin-right">
                    <button type="button" class="button number-down">-</button>
                    <input type="text" name="order" value="1" class="input-unstyled order" size="2">
                    <button type="button" class="button number-up">+</button>
                </span>
                <span class="button-group">
					<label for="active-1" class="button blue-active">
						<input type="radio" name="active" id="active-1" value="{{constLang('active_true')}}" checked>
                        {{constLang('active_true')}}
					</label>
					<label for="active-0" class="button red-active">
						<input type="radio" name="active" id="active-0" value="{{constLang('active_false')}}">
                        {{constLang('active_false')}}
					</label>
				</span>
            </p>

            <p class="button-height align-center">
                <span class="button-group">
                    <button onclick="fechaModal()" class="button"> Cancelar </button>
                    @can('contents-site-create')
                        <button id="btn-modal" onclick="formContents('create', 'contents', '{{route('contract.load')}}')" class="button blue-gradient">
                        <span class="icon-publish"></span> Salvar
                    </button>
                    @endcan
                </span>
            </p>
        </fieldset>
    </form>
</div>
