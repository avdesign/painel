<div id="modal-notes" xmlns="http://www.w3.org/1999/html">
	<form id="form-notes" method="POST" action="{{route('notes.update', ['id' => $data->id, 'user_id' => $data->user_id])}}" onsubmit="return false">
		@method("PUT")
		@csrf
		<fieldset class="fieldset">
			<p class="block-label button-height">
				<label for="label" class="label"> Observação <span class="red">*</span></label>
				<input type="text" name="notes[label]" id="label" class="input full-width" value="{{$data->label}}">
			</p>
			<p class="block-label button-height">
				<label for="label" class="label"> Descrição <span class="red">*</span></label>
				<textarea rows="5" name="notes[description]" id="description" class="input full-width">{{$data->description}}</textarea>
			</p>


		</fieldset>
		<p class="button-height align-center">
			<span class="button-group">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
				@can('account-update')
					<button id="btn-modal" onclick="formNotes('update', '{{route('account-notes.refresh', $data->user_id)}}')" class="button icon-publish blue-gradient"> Alterar </button>
				@endcan
			</span>
		</p>

	</form>
</div>
