<div id="modal-profiles">
	<form id="form-profiles" method="POST" action="{{route('profiles.update', $data->id)}}" onsubmit="return false">
		@method("PUT")
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="name" class="label"> Perfil <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="{{$data->name}}">
			</p>

			<p class="button-height inline-label">
				<label for="label" class="label"> Descrição <span class="red">*</span></label>
				<textarea name="label" class="input full-width autoexpanding">{{$data->label}}</textarea>
			</p>
			<p class="button-height align-center">
				<span class="button-group">
					<button onclick="fechaModal()" class="button"> Cancelar </button>
					<button id="btn-modal" onclick="formProfile('update')" class="button icon-	outbox blue-gradient">
						<span class="icon-outbox"></span> Alterar
					</button>
				</span>
			</p>
		</fieldset>
	</form>
</div>