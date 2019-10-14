<div id="modal-modules">
	<form id="form-modules" method="POST" action="{{route('modules.update', $data->id)}}" onsubmit="return false">
		@method("PUT")
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="name" class="label"> Modulo <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="{{$data->name}}">
			</p>
			<p class="button-height inline-label">
				<label for="name" class="label"> Tipo <span class="red">*</span></label>
				<span class="button-group">
					<label for="type-1" class="button green-active">
						<input type="radio" name="type" id="type-1" value="C"
						 @if($data->type == 'C') checked @endif>C
					</label>
					<label for="type-2" class="button green-active">
						<input type="radio" name="type" id="type-2" value="A"
						 @if($data->type == 'A') checked @endif>A
					</label>
					<label for="type-3" class="button green-active">
						<input type="radio" name="type" id="type-3" value="R"
						 @if($data->type == 'R') checked @endif>R
					</label>
				</span>
			</p>

			<p class="button-height inline-label">
				<label for="label" class="label"> Descrição <span class="red">*</span></label>
				<textarea name="label" class="input full-width autoexpanding">{{$data->label}}</textarea>
			</p>
			<p class="button-height inline-label">
				<label for="order" class="label"> Ordem <span class="red">*</span></label>
				<span class="number input margin-right">
					<button type="button" class="button number-down">-</button>
					<input type="text" name="order" value="{{$data->order}}" size="2" class="input-unstyled order">
					<button type="button" class="button number-up">+</button>
				</span>
			</p>

			<p class="button-height align-center">
				<span class="button-group">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
					@can('config-module-update')
						<button id="btn-modal" onclick="formModule('update')" class="button icon-	outbox blue-gradient">
						<span class="icon-outbox"></span> Alterar
						</button>
					@endcan
				</span>
			</p>
		</fieldset>
	</form>
</div>