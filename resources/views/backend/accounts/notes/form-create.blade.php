<div id="modal-notes" xmlns="http://www.w3.org/1999/html">
	<form id="form-notes" method="POST" action="{{route('notes.store', $user->id)}}" onsubmit="return false">
		@csrf
		<fieldset class="fieldset">

			<p class="block-label button-height">
				<label for="label" class="label"> Observação <span class="red">*</span></label>
				<input type="text" name="notes[label]" id="label" class="input full-width" value="">
			</p>
			<p class="block-label button-height">
				<label for="label" class="label"> Descrição <span class="red">*</span></label>
				<textarea rows="5" name="notes[description]" id="description" class="input full-width"></textarea>
			</p>


		</fieldset>
		<p class="button-height align-center">
			<span class="button-group">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
				@can('account-create')
					<button id="btn-modal" onclick="formNotes('create', '{{route('account-notes.refresh', $user->id)}}')" class="button icon-publish blue-gradient"> Alterar </button>
				@endcan
			</span>
		</p>
	</form>
</div>
