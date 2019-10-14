<div id="modal-shippings">
	<form id="form-shippings" method="POST" action="{{route('shippings.update', $data->id)}}" onsubmit="return false">
		@method("PUT")
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="name" class="label">Método <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="{{$data->name}}" >
			</p>

			<p class="button-height inline-label">
				<label for="description" class="label">Descrição <span class="red">*</span></label>
				<textarea name="description" class="input full-width" cols="30" rows="3">{{$data->description}}</textarea>
			</p>

			<p class="hide">
				<input type="hidden" name="url_metodo">
			</p>

			<p class="button-height inline-label">
				<label for="order" class="label">Ordem / Status / Taxa</label>
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

				<span class="button-group">
					<label for="tax-1" class="button blue-active">
						<input type="radio" name="tax" id="tax-1" value="1" @if($data->tax == 1) checked @endif>
						{{constLang('yes')}}
					</label>
					<label for="tax-0" class="button red-active">
						<input type="radio" name="tax" id="tax-0" value="0" @if($data->tax == 0) checked @endif>
						{{constLang('not')}}
					</label>
				</span>

			</p>

			<p class="button-height">
				<label for="tax_unique" class="label"><b>Taxa Única</b> </label>
				<span class="input">
				<input type="text" name="tax_unique" id="tax_unique" class="input-unstyled" value="{{$data->tax_unique}}">
				<span class="info-spot">
						<span class="icon-info-round"></span>
						<span class="info-bubble">
							Valor fixo e único, não é obrigatório
						</span>
					</span>
				</span>
			</p>

			<p class="button-height">
				<label for="tax_condition" class="label"><b>Valor Mínimo</b> </label>
				<span class="input">
				<input type="text" name="tax_condition" id="tax_condition" class="input-unstyled" value="{{$data->tax_condition}}">
				<span class="info-spot">
						<span class="icon-info-round"></span>
						<span class="info-bubble">
							Valor mínimo para entrega, não é obrigatório.
						</span>
					</span>
				</span>
			</p>

			<p class="button-height align-center">
				<span class="button-group">
					<button onclick="fechaModal()" class="button"> Cancelar </button>
					@can('config-shipping-update')
						<button id="btn-modal" onclick="formShipping('update', 'shippings','{{route('shippings.show', 1)}}')" class="button icon-	outbox blue-gradient">
						<span class="icon-publish"></span> Alterar 
						</button>
					@endcan
				</span>
			</p>
		</fieldset>
	</form>
</div>
