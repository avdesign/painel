<div id="modal-brands">
	<form id="form-brands" method="POST" action="{{route('brands.store')}}" onsubmit="return false">
		@csrf
		<fieldset class="fieldset">
			<legend class="legend">Informações da Marca</legend>
			<p class="button-height inline-label">
				<label for="name" class="label"> Nome <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="tags" class="label"> Tags </label>
				<input type="text" name="tags" class="input full-width" value="">
			</p>

			@if($configModel->description == 1)
				<p class="button-height inline-label">
					<label for="description" class="label">Descrição <span class="red">*</span></label>
					<textarea name="description" class="input full-width" cols="50" rows="2"></textarea>
				</p>
			@endif


			<p class="button-height inline-label">
				<label for="status" class="label">Ordem / Status </label>
				<span class="number input margin-right">
					<button type="button" class="button number-down">-</button>
					<input type="text" name="order" value="" size="2" class="input-unstyled order">
					<button type="button" class="button number-up">+</button>
				</span>

				<span class="button-group">
					<label for="active-1" class="button blue-active">
						<input type="radio" name="active" id="active-1" value="{{constLang('active_true')}}" checked>
						{{constLang('active_true')}}
					</label>
					<label for="active-0" class="button red-active">
						<input type="radio" name="active" id="active-0" value="{{constLang('active_false')}}">
						{{constLang('active_false')}}
					</label>
				</span>
			</p>

			@if($configModel->img_logo == 1)
				<p class="button-height inline-label">
					<label for="active_logo" class="label">Status Logo</label>
					<span class="button-group">
						<label for="active_logo-1" class="button blue-active">
							<input type="radio" name="active_logo" id="active_logo-1" value="{{constLang('active_true')}}" checked>
							{{constLang('active_true')}}
						</label>
						<label for="active_logo-0" class="button red-active">
							<input type="radio" name="active_logo" id="active_logo-0" value="{{constLang('active_false')}}">
							{{constLang('active_false')}}
						</label>
					</span>
				</p>
			@endif

			@if($configModel->img_banner == 1)
				<p class="button-height inline-label">
					<label for="active_banner" class="label">Status Banner </label>
					<span class="button-group">
						<label for="active_banner-1" class="button blue-active">
							<input type="radio" name="active_banner" id="active_banner-1" value="{{constLang('active_true')}}" checked>
							{{constLang('active_true')}}
						</label>
						<label for="active_banner-0" class="button red-active">
							<input type="radio" name="active_banner" id="active_banner-0" value="{{constLang('active_false')}}">
							{{constLang('active_false')}}
						</label>
					</span>
				</p>
			@endif
		</fieldset>
			<!-- Informações-->

		@if($configModel->info == 1)
			<fieldset class="fieldset">
				<legend class="legend">Informações do Fabricante</legend>
				<p class="button-height inline-label">
					<label for="email" class="label"> Email </label>
					<input type="email" name="email" class="input full-width" value="">
				</p>
				<p class="button-height inline-label">
					<label for="phone" class="label"> Telefone </label>
					<input type="text" id="phone" name="phone" class="input full-width" value="">
				</p>
				<p class="button-height inline-label">
					<label for="contact" class="label"> Nome contato </label>
					<input type="text" id="contact" name="contact" class="input full-width" value="">
				</p>
				<p class="button-height inline-label">
					<label for="address" class="label"> Endereço </label>
					<input type="text" name="address" class="input full-width" value="">
				</p>
				<p class="button-height inline-label">
					<label for="number" class="label"> Número </label>
					<input type="text" name="number" class="input full-width" value="">
				</p>
				<p class="button-height inline-label">
					<label for="district" class="label"> Bairro </label>
					<input type="text" name="district" class="input full-width" value="">
				</p>
				<p class="button-height inline-label">
					<label for="city" class="label"> Cidade </label>
					<input type="text" name="city" class="input full-width" value="">
				</p>
				<p class="button-height inline-label">
					<label for="state" class="label">Estado </label>
					<select name="state" class="select">
						<option value=""> Selecione o Estado </option>
						@foreach($options as $key => $val)
							<option value="{{$key}}"> {{$val}} </option>
						@endforeach
					</select>
				</p>
				<p class="button-height inline-label">
					<label for="zip_code" class="label"> CEP </label>
					<input type="text" id="zip_code" name="zip_code" class="input full-width" value="">
				</p>
			</fieldset>
		@endif

		<p class="button-height align-center">
			<span class="button-group">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
				@can('brand-create')
					<button id="btn-modal" onclick="formBrand('create')" class="button icon-publish blue-gradient"> Salvar </button>
				@endcan
			</span>
		</p>
		
	</form>
</div>
<!-- Mask -->
<script src="{{mix('backend/js/libs/Mask/jquery.maskedinput.min.js')}}"></script>

<script>
$( document ).ready(function() {
    $("#phone").mask("(99) 9999-9999?9");
    $("#zip_code").mask("99999-999"); 
});
</script>