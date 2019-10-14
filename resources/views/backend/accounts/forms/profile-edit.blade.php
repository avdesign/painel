<div id="modal-accounts">
	<form id="form-accounts" method="POST" action="{{route('accounts.update', $data->id)}}" onsubmit="return false">
		<input name="_method" type="hidden" value="PUT">
		{{csrf_field()}}
		<fieldset class="fieldset">
			<legend class="legend">Perfil do Cliente</legend>
			<p class="button-height inline-label">
				<label for="profile" class="label"> Perfil <span class="red">*</span></label>
	            <select id="select-profile-update" name="user[profile_id]" class="select">
	                @foreach($profiles as $key => $val)
						@if($key != 1)
		            		<option value="{{$key}}"@if($data->profile_id == $key) selected @endif> {{$val}} </option>
						@endif
	                @endforeach
	            </select>
	        </p>
			<p class="button-height inline-label">
				<label for="admin" class="label"> Vendedor <span class="red">*</span></label>
				<select name="user[admin]" class="select">
					<option value="">Selecione um</option>
					@foreach($admins as $id => $name)
						<option value="{{$name}}" @if($data->admin == $name) selected @endif> {{$name}} </option>
					@endforeach
				</select>
			</p>

			<div id="load-profile">
				@if($data->profile_id == 2)
					<p class="button-height inline-label">
						<label for="first_name" class="label"> Nome <span class="red">*</span></label>
						<input type="text" id="first_name" name="user[first_name]" class="input full-width" value="{{$data->first_name}}">
					</p>
					<p class="button-height inline-label">
						<label for="last_name" class="label"> Sobre Nome <span class="red">*</span></label>
						<input type="text" id="last_name" name="user[last_name]" class="input full-width" value="{{$data->last_name}}">
					</p>
					<p class="button-height inline-label">
						<label for="document1" class="label"> CPF <span class="red">*</span></label>
						<input type="text" id="document1" name="user[document1]" class="input full-width" value="{{$data->document1}}">
					</p>
					<p class="button-height inline-label">
						<label for="document2" class="label"> RG <span class="red">*</span></label>
						<input type="text" id="document2" name="user[document2]" class="input full-width" value="{{$data->document2}}">
					</p>
					<p/>
					<script>
                        $( document ).ready(function() {
                            $("#document1").mask("999.999.999-99");
                        });
					</script>
				@endif

				@if($data->profile_id == 3)
					<p class="button-height inline-label">
						<label for="last_name" class="label"> Razão Social <span class="red">*</span></label>
						<input type="text" id="last_name" name="user[last_name]" class="input full-width" value="{{$data->last_name}}">
					</p>
					<p class="button-height inline-label">
						<label for="first_name" class="label"> Nome Fantasia <span class="red">*</span></label>
						<input type="text" id="first_name" name="user[first_name]" class="input full-width" value="{{$data->first_name}}">
					</p>
					<p class="button-height inline-label">
						<label for="document1" class="label"> CNPJ <span class="red">*</span></label>
						<input type="text" id="document1" name="user[document1]" class="input full-width" value="{{$data->document1}}">
					</p>
					<p class="button-height inline-label">
						<label for="document2" class="label"> Insc. Estadual <span class="red">*</span></label>
						<input type="text" id="document2" name="user[document2]" class="input full-width" value="{{$data->document2}}">
					</p>
					<p/>
					<script>
						$( document ).ready(function() {
							$("#document1").mask("99.999.999/9999-99");
						});
					</script>
				@endif
			</div>

			<p class="button-height inline-label">
				<label for="email" class="label"> Email <span class="red">*</span></label>
				<input type="email" name="user[email]" class="input full-width" value="{{$data->email}}">
			</p>
			<p class="button-height inline-label">
				<label for="cell" class="label"> Celular <span class="red">*</span></label>
				<input type="text" id="cell" name="user[cell]" class="input full-width" value="{{$data->cell}}">
			</p>
			<p class="button-height inline-label">
				<label for="phone" class="label"> Telefone </label>
				<input type="text" id="phone" name="user[phone]" class="input full-width" value="{{$data->phone}}">
			</p>
			<p class="button-height inline-label">
				<label for="date" class="label"> Nascimento <span class="red">*</span></label>
				<input type="text" id="date" name="user[date]" class="input" value="{{$data->date}}">
			</p>
			<p class="button-height inline-label">
				<label for="status" class="label">É Cliente <span class="red">*</span></label>
				<span class="button-group">
					<label for="client-1" class="button blue-active">
						<input type="radio" name="user[client]" id="client-1" value="1" @if($data->client == 1) checked @endif>
						Sim
					</label>
					<label for="client-0" class="button red-active">
						<input type="radio" name="user[client]" id="client-0" value="0" @if($data->client == 0) checked @endif>
						Não
					</label>
				</span>
			</p>
			<p class="button-height inline-label">
				<label for="status" class="label">Status <span class="red">*</span></label>
				<span class="button-group">
					<label for="active-1" class="button blue-active">
						<input type="radio" name="user[active]" id="active-1" value="{{constLang('active_true')}}" @if($data->active == constLang('active_true')) checked @endif>
						{{constLang('active_true')}}
					</label>
					<label for="active-0" class="button red-active">
						<input type="radio" name="user[active]" id="active-0" value="{{constLang('active_false')}}" @if($data->active == constLang('active_false')) checked @endif>
						{{constLang('active_false')}}
					</label>
				</span>
			</p>
			<p class="button-height inline-label">
				<label for="newsletter" class="label">Newsletter <span class="red">*</span></label>
				<span class="button-group">
					<label for="newsletter-1" class="button blue-active">
						<input type="radio" name="user[newsletter]" id="newsletter-1" value="1" @if($data->newsletter == 1) checked @endif>
						{{constLang('active_true')}}
					</label>
					<label for="newsletter-0" class="button red-active">
						<input type="radio" name="user[newsletter]" id="newsletter-0" value="0" @if($data->newsletter == 0) checked @endif>
						{{constLang('active_false')}}
					</label>
				</span>
			</p>

			<p class="button-height">
				<input type="checkbox" value="1" name="user[reset_password]" class="checkbox" id="reset-password">
				<label class="label"><strong>Alterar Senha</strong></label>
			</p>

			<div id="box-reset-password">
				<p class="button-height inline-label">
					<label for="password" class="label"> Senha <span class="red">*</span></label>
					<input type="password" name="user[password]" class="input full-width" >
				</p>
				<p class="button-height inline-label">
					<label for="password" class="label">Confirme Senha<span class="red">*</span></label>
					<input type="password" name="user[password_confirmation]"  class="input full-width" >
				</p>
			</div>

		</fieldset>

		<p class="button-height align-center">
			<span class="button-group">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
				@can('account-update')
					<button id="btn-modal" onclick="formAccount('update')" class="button icon-publish blue-gradient"> Salvar </button>
					<input name="user[id]" type="hidden" value="{{$data->id}}">
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
    $('#select-profile-update').on("change",function() {
        var opc = $(this).val();
        var id  = {{$data->id}};
        loadProfileUpdate(opc,id);
    });
    loadProfileUpdate = function (opc,id) {
        $.ajax({
            url: 'account/load/profile/'+ opc+'/update/'+id,
            success: function (response) {
                $("#load-profile").html(response);
            },
            error: function (xhr) {
                ajaxFormError(xhr);
            }
        });
    }
    $("#reset-password").on('change', function() {
        $("#box-reset-password").toggle(this.checked);
    }).triggerHandler('change');
});
</script>