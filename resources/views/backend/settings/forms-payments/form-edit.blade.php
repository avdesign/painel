<div id="modal-payments">
	<form id="form-payment" method="POST" action="{{route('forms-payments.update', $data->id)}}" onsubmit="return false">
		@method("PUT")
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="method" class="label">Método (inglês)<span class="red">*</span></label>
				<input type="text" name="method" class="input full-width" value="{{$data->method}}" >
			</p>
			<p class="button-height inline-label">
				<label for="label" class="label">Forma <span class="red">*</span></label>
				<input type="text" name="label" class="input full-width" value="{{$data->label}}" >
			</p>

			<p class="button-height inline-label">
				<label for="description" class="label">Descrição <span class="red">*</span></label>
				<textarea name="description" class="input full-width" cols="1" rows="5">{{$data->description}}</textarea>
			</p>

			<p class="button-height inline-label">
				<label for="order" class="label">Ordem / Status</label>
				<span class="number input margin-right">
					<button type="button" class="button number-down">-</button>
					<input type="text" name="order" value="{{$data->order}}" class="input-unstyled order" size="2">
					<button type="button" class="button number-up">+</button>
				</span>
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
					@can('config-form-payment-update')
						<button id="btn-modal" onclick="formPayments('update', 'payment','{{route('forms-payments.show', 1)}}')" class="button icon-	outbox blue-gradient">
						<span class="icon-publish"></span> Alterar 
						</button>
					@endcan
				</span>
			</p>
		</fieldset>
	</form>
</div>
