<div id="modal-status-payments">
	<form id="form-status-payments" method="POST" action="{{route('status-payments.update', $data->id)}}" onsubmit="return false">
		@method("PUT")
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="gateway" class="label">Gateway <span class="red">*</span></label>
				<input type="text" name="gateway" class="input full-width" value="{{$data->gateway}}" >
			</p>
			<p class="button-height inline-label">
				<label for="label" class="label">Nome <span class="red">*</span></label>
				<input type="text" name="label" class="input full-width" value="{{$data->label}}" >
			</p>

			<p class="button-height inline-label">
				<label for="description" class="label">Descrição <span class="red">*</span></label>
				<textarea name="description" class="input full-width" cols="30" rows="3">{{$data->description}}</textarea>
			</p>

			<p class="button-height inline-label">
				<label for="description" class="label">Ord|Tipo|Cod <span class="red">*</span></label>
				<span class="number input margin-right">
					<button type="button" class="button number-down">-</button>
					<input type="text" name="order" value="{{$data->order}}" class="input-unstyled order" size="2">
					<button type="button" class="button number-up">+</button>
				</span>
				<span class="button-group">
					<label for="type-1" class="button green-active">
						<input type="radio" name="type" id="type-1" value="C" @if($data->type == 'C') checked @endif>
						C
					</label>
					<label for="type-2" class="button green-active">
						<input type="radio" name="type" id="type-2" value="S" @if($data->type == 'S') checked @endif>
						S
					</label>
				</span>
				<span class="number input margin-right">
					<input type="text" name="status" value="{{$data->status}}" class="input-unstyled order" size="3">
				</span>
			</p>

			<p class="button-height inline-label">
				<label for="status" class="label"> Status</label>
				<span class="button-group">
					<label for="active-1" class="button blue-active">
						<input type="radio" name="active" id="active-1" value="{{constLang('active_true')}}" @if($data->active == constLang('active_true')) checked @endif>
						{{constLang('active_true')}}
					</label>
					<label for="active-0" class="button red-active">
						<input type="radio" name="active" id="active-0" value="{{constLang('active_false')}}" @if($data->active == constLang('active_false')) checked @endif>
						{{constLang('active_false')}}
					</label>
				</span>
			</p>
			<p class="button-height align-center">
				<span class="button-group">
					<button onclick="fechaModal()" class="button"> Cancelar </button>
					@can('config-status-payments-update')
						<button id="btn-modal" onclick="formStatusPayments('update', 'status-payments','{{route('status-payments.show', 1)}}')" class="button icon-	outbox blue-gradient">
						<span class="icon-publish"></span> Alterar 
						</button>
					@endcan
				</span>
			</p>
		</fieldset>
	</form>
</div>
