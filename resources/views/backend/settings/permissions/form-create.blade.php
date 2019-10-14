<div id="modal-permissions">
	<form id="form-permissions" method="POST" action="{{route('permissions.store')}}" onsubmit="return false">
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="model" class="label"> Modulo <span class="red">*</span></label>
				<select id="select-models" name="module_id" class="select">
					<option value="">Selecione um</option>
					@foreach($options as $key => $val)
						<option value="{{$key}}"> {{$val}} </option>
					@endforeach
				</select>
			</p>
			<p class="button-height inline-label">
				<label for="name" class="label"> Permissão <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="">
			</p>

			<p class="button-height inline-label">
				<label for="label" class="label"> Descrição <span class="red">*</span></label>
				<textarea name="label" class="input full-width autoexpanding"></textarea>
			</p>

			<p class="button-height align-center">
				<span class="button-group">
					<button onclick="fechaModal()" class="button"> Cancelar </button>
					<button id="btn-modal" onclick="formPermission('create')" class="button blue-gradient">
						<span class="icon-outbox"></span> Salvar
					</button>
				</span>
			</p>
		</fieldset>
	</form>
</div>