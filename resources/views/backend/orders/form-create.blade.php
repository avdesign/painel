<div id="modal-orders">
	<form id="form-orders" method="POST" action="{{route('orders.store')}}" onsubmit="return false">
		@csrf
		<fieldset class="fieldset">
			<legend class="legend">Informações do Pedido</legend>
			<p class="button-height inline-label">
				<label for="user_id" class="label"> Código Cliente <span class="red">*</span></label>
				<input type="text" name="user_id" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="config_status_payment_id" class="label">Status <span class="red">*</span></label>
				<select name="config_status_payment_id" class="select">
					<option value=""> Selecione o status </option>
					@foreach($status as $keys => $vals)
						<option value="{{$keys}}"> {{$vals}} </option>
					@endforeach
				</select>
			</p>
			<p class="button-height inline-label">
				<label for="config_form_payment_id" class="label">Pagamento <span class="red">*</span></label>
				<select name="config_form_payment_id" class="select">
					@foreach($forms as $keyf => $valf)
						<option value="{{$keyf}}"> {{$valf}} </option>
					@endforeach
				</select>
			</p>
		</fieldset>

		<p class="button-height align-center">
			<span class="button-group">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
				@can('orders-create')
					<button id="btn-modal" onclick="formOrders('create', 'orders')" class="button icon-publish blue-gradient"> Salvar </button>
				@endcan
			</span>
		</p>
	</form>
</div>
