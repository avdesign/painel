<div id="modal-subjects">
    <form id="form-subjects" method="POST" action="{{route('contact-subjects.store')}}" onsubmit="return false">
        @csrf
        <fieldset class="fieldset">
            <p class="button-height inline-label">
                <label for="label" class="label"> Assunto <span class="red">*</span></label>
                <input type="text" name="label" class="input full-width" value="">
            </p>
            <p class="button-height block-label">
                <label for="message" class="label"> Mensagem <span class="red">*</span></label>
                <textarea rows="10" name="message" class="input full-width"></textarea>
            </p>
            <p class="button-height inline-label">
                <label for="order" class="label">Visitantes <span class="red">*</span></label>
                <span class="button-group">
                    <label for="send_guest_1" class="button blue-active">
                        <input type="radio" name="send_guest" id="send_guest_1" value="1" checked>
                        Enviar mensagem
                    </label>
                    <label for="send_guest_0" class="button red-active">
                        <input type="radio" name="send_guest" id="send_guest_0" value="0">
                        Não enviar mensagem
                    </label>
                </span>
            </p>

            <p class="button-height inline-label">
                <label for="order" class="label">Clientes <span class="red">*</span></label>
                <span class="button-group">
                    <label for="send_user_1" class="button blue-active">
                        <input type="radio" name="send_user" id="send_user_1" value="1" checked>
                        Enviar mensagem
                    </label>
                    <label for="send_user_0" class="button red-active">
                        <input type="radio" name="send_user" id="send_user_0" value="0">
                        Não enviar mensagem
                    </label>
                </span>
            </p>
            <p class="button-height inline-label">
                <label for="order" class="label">Ordem / Status <span class="red">*</span></label>
                <span class="number input margin-right">
                    <button type="button" class="button number-down">-</button>
                    <input type="text" name="order" value="" class="input-unstyled order" size="2">
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
                    @can('config-subject-create')
                        <button id="btn-modal" onclick="formSubjects('create', 'subjects', '{{route('contact-subjects.load')}}')" class="button blue-gradient">
                        <span class="icon-publish"></span> Salvar
                    </button>
                    @endcan
                </span>
            </p>
        </fieldset>
    </form>
</div>
