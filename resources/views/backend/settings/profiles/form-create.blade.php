<div id="modal-profiles">
	<form id="form-profiles" method="POST" action="{{route('profiles.store')}}" onsubmit="return false">
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="name" class="label"> Perfil <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="">
			</p>

			<p class="button-height inline-label">
				<label for="label" class="label"> Descrição <span class="red">*</span></label>
				<textarea name="label" class="input full-width autoexpanding"></textarea>
			</p>
			<p class="button-height align-center">
				<span class="button-group">
					<button onclick="fechaModal()" class="button"> Cancelar </button>

					<button id="btn-modal" onclick="formProfile('create')" class="button blue-gradient">
						<span class="icon-outbox"></span> Salvar
					</button>
				</span>
			</p>
		</fieldset>
	</form>
</div>