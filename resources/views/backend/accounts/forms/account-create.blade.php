<div id="modal-accounts">
	<form id="form-accounts" method="POST" action="{{route('accounts.store')}}" onsubmit="return false">
		@csrf
		<fieldset class="fieldset">
			<legend class="legend">Perfil do Cliente</legend>
			<p class="button-height inline-label">
				<label for="profile" class="label"> Perfil <span class="red">*</span></label>
	            <select id="select-profile" name="user[profile_id]" class="select">
	                @foreach($profiles as $key => $val)
						@if($key != 1)
		            		<option value="{{$key}}"> {{$val}} </option>
						@endif
	                @endforeach
	            </select>
	        </p>
			<p class="button-height inline-label">
				<label for="admin" class="label"> Vendedor <span class="red">*</span></label>
				<select name="user[admin]" class="select">
					<option value="">Selecione um</option>
					@foreach($admins as $id => $name)
						<option value="{{$name}}"> {{$name}} </option>
					@endforeach
				</select>
			</p>

			<div id="load-profile"></div>

			<p class="button-height inline-label">
				<label for="email" class="label"> Email <span class="red">*</span></label>
				<input type="email" name="user[email]" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="cell" class="label"> Celular <span class="red">*</span></label>
				<input type="text" id="cell" name="user[cell]" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="phone" class="label"> Telefone </label>
				<input type="text" id="phone" name="user[phone]" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="date" class="label"> Nascimento <span class="red">*</span></label>
				<input type="text" id="date" name="user[date]" class="input" value="">
				<span class="info-spot">
					<span class="icon-info-round"></span>
					<span class="info-bubble">Ex: dd/mm/aaaa</span>
				</span>
			</p>
			<p class="button-height inline-label">
				<label for="status" class="label">É Cliente <span class="red">*</span></label>
				<span class="button-group">
					<label for="client-1" class="button blue-active">
						<input type="radio" name="user[client]" id="client-1" value="1" checked>Sim
					</label>
					<label for="client-0" class="button red-active">
						<input type="radio" name="user[client]" id="client-0" value="0">Não
					</label>
				</span>
			</p>
			<p class="button-height inline-label">
				<label for="status" class="label">Status <span class="red">*</span></label>
				<span class="button-group">
					<label for="active-1" class="button blue-active">
						<input type="radio" name="user[active]" id="active-1" value="{{constLang('active_true')}}" checked>{{constLang('active_true')}}
					</label>
					<label for="active-0" class="button red-active">
						<input type="radio" name="user[active]" id="active-0" value="{{constLang('active_false')}}">{{constLang('active_false')}}
					</label>
				</span>
			</p>
			<p class="button-height inline-label">
				<label for="newsletter" class="label">Newsletter <span class="red">*</span></label>
				<span class="button-group">
					<label for="newsletter-1" class="button blue-active">
						<input type="radio" name="user[newsletter]" id="newsletter-1" value="1" checked>{{constLang('active_true')}}
					</label>
					<label for="newsletter-0" class="button red-active">
						<input type="radio" name="user[newsletter]" id="newsletter-0" value="0">{{constLang('active_false')}}
					</label>
				</span>
			</p>
			<p class="button-height inline-label">
				<label for="password" class="label"> Senha <span class="red">*</span></label>
				<input type="password" name="user[password]" class="input full-width" >
			</p>
			<p class="button-height inline-label">
				<label for="password" class="label">Confirme Senha<span class="red">*</span></label>
				<input type="password" name="user[password_confirmation]" class="input full-width" >
			</p>
		</fieldset>

		<fieldset class="fieldset">
			<legend class="legend">Endereço de Entrega</legend>
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
				<label for="complement" class="label"> Complemento <span class="red">*</span></label>
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
					<button id="btn-modal" onclick="formAccount('create')" class="button icon-publish blue-gradient"> Salvar </button>
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
    $("#cell").mask("(99) 9999-9999?9");
    $("#date").mask("99/99/9999");
    $("#zip_code").mask("99999-999");
    $('#select-profile').on("change",function() {
        var opc = $(this).val();
        loadProfile(opc);
    });

    loadProfile = function (opc) {
        $.ajax({
            url: 'account/load/profile/' + opc,
            success: function (response) {
                $("#load-profile").html(response);
            },
            error: function (xhr) {
                ajaxFormError(xhr);
            }
        });
    }
    loadProfile(2);
});
</script>