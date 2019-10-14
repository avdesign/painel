<div id="modal-permissions">
	<form id="form-permissions" method="POST" action="{{route('permissions.update', $data->id)}}" onsubmit="return false">
		<input name="_method" type="hidden" value="PUT">
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="model" class="label"> Modulo <span class="red">*</span></label>
				<select id="select-models" name="module_id" class="select">
					<option value="">Selecione um</option>
					@foreach($options as $key => $val)
						<option value="{{$key}}"@if($data->module_id == $key) selected @endif> {{$val}} </option>
					@endforeach
				</select>
			</p>
			<p class="button-height inline-label">
				<label for="name" class="label"> Permissão <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="{{$data->name}}">
			</p>

			<p class="button-height inline-label">
				<label for="label" class="label"> Descrição <span class="red">*</span></label>
				<textarea name="label" class="input full-width autoexpanding">{{$data->label}}</textarea>
			</p>

			<p class="button-height align-center">
				<span class="button-group">
					<button onclick="fechaModal()" class="button"> Cancelar </button>
					<button id="btn-modal" onclick="formPermission('update')" class="button icon-	outbox blue-gradient">
						<span class="icon-outbox"></span> Alterar
					</button>
				</span>
			</p>
		</fieldset>
	</form>
</div>