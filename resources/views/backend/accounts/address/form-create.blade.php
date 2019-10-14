<div id="modal-address">
	<form id="form-address" method="POST" action="{{route('address.store', $user->id)}}" onsubmit="return false">
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-medium-label">
				<label for="delivery" class="label">Endereço de Entrega <span class="red">*</span></label>
				<span class="button-group">
					<label for="delivery-1" class="button blue-active">
						<input type="radio" name="address[delivery]" id="delivery-1" value="1" checked>
						Sim
					</label>
					<label for="delivery-0" class="button red-active">
						<input type="radio" name="address[delivery]" id="delivery-0" value="0">
						Não
					</label>
				</span>
			</p>
			<p class="button-height inline-label">
				<label for="zip_code" class="label"> CEP <span class="red">*</span></label>
				<input type="text" name="address[zip_code]" id="zip_code" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="states" class="label"> Estado <span class="red">*</span></label>
				<select id="states" name="address[state]" class="select">
					<option value="">Selecione um</option>
					@foreach($states as $uf => $name)
						<option value="{{$uf}}"> {{$name}} </option>
					@endforeach
				</select>
			</p>
			<p class="button-height inline-label">
				<label for="address" class="label"> Endereço <span class="red">*</span></label>
				<input type="text" name="address[address]" id="address" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="number" class="label"> Número <span class="red">*</span></label>
				<input type="text" name="address[number]" id="number" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="complement" class="label"> Complemento </label>
				<input type="text" name="address[complement]" id="complement" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="district" class="label"> Bairro <span class="red">*</span></label>
				<input type="text" name="address[district]" id="district" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="city" class="label"> Cidade <span class="red">*</span></label>
				<input type="text" name="address[city]" id="city" class="input full-width" value="">
			</p>

		</fieldset>
		<p class="button-height align-center">
			<span class="button-group">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
				@can('account-create')
					<button id="btn-modal" onclick="formAddress('create', '{{route('account-address.refresh', $user->id)}}')" class="button icon-publish blue-gradient"> Alterar </button>
				@endcan
			</span>
		</p>

	</form>
</div>
<!-- Mask -->
<script src="{{mix('backend/js/libs/Mask/jquery.maskedinput.min.js')}}"></script>

<script>
$( document ).ready(function() {
    $("#zip_code").mask("99999-999");
});
</script>