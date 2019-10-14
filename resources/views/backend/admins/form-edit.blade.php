<div id="modal-admins">
	<form id="form-admins" method="POST" action="{{route('admins.update', $data->id)}}" onsubmit="return false">
		@csrf
		@method('PUT')
		<input name="has" type="hidden" value="{{$code}}">

		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="profile" class="label"> Perfil <span class="red">*</span></label>
	            <select id="select-profile" name="profile_id" class="select">
	            	<option value="">Selecione um</option>
	                @foreach($options as $key => $val)
	                	@if($val != 'Master')
		                    <option value="{{$key}}" @if($data->profile == $val) selected @endif> {{$val}} </option>
		                @endif
	                @endforeach
	            </select>
	        </p>
			<p class="button-height inline-label">
				<label for="name" class="label"> Nome <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="{{$data->name}}">
			</p>
			<p class="button-height inline-label">
				<label for="email" class="label"> Email <span class="red">*</span></label>
				<input type="email" name="email" class="input full-width" value="{{$data->email}}">
			</p>
			<p class="button-height inline-label">
				<label for="phone" class="label"> Telefone <span class="red">*</span></label>
				<input type="text" id="phone" name="phone" class="input full-width" value="{{$data->phone}}">
			</p>
			<p class="button-height inline-label">
				<label for="login" class="label"> Login <span class="red">*</span></label>
				<input type="text" name="login" maxlength="10" class="input full-width" value="{{$data->login}}">
			</p>
			<p class="button-height inline-label">
				<label for="commission" class="label"> Comissão<span class="red">*</span></label>
				<span class="input">
					<select id="commission" name="commission" class="select compact">
						<option value="Sim" @if($data->commission == 'Sim') selected @endif>SIM</option>
						<option value="Não" @if($data->commission == 'Não') selected @endif>NÃO</option>
					</select>
					<span class="number input">
						<button type="button" class="button number-down">-</button>
						<input type="text" name="percent" value="{{ $data->percent}}" size="6" class="input-unstyled" data-number-options='{"min":0,"max":30,"increment":0.5,"shiftIncrement":5,"precision":0.25}'>
						<button type="button" class="button number-up">+</button>
					</span>

					<label for="percent" class="button blue-gradient">
						<i class="fa fa-percent" aria-hidden="true"></i>
					</label>
				</span>
			</p>
			<p class="button-height inline-label">
				<label for="active" class="label">Status <span class="red">*</span></label>
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

			<p class="button-height inline-label">
				<label for="login" class="label"> Login <span class="red">*</span></label>
				<input type="text" name="login" maxlength="10" class="input full-width" value="{{$data->login}}">
			</p>
			<p class="button-height">
				<input type="checkbox" value="1" name="reset-password" class="checkbox" id="reset-password">
				<label class="label"><strong>Alterar Senha</strong></label>
			</p>

			<div id="box-reset-password">
				<p class="button-height inline-label">
					<label for="password" class="label"> Senha <span class="red">*</span></label>
					<input type="password" name="password" maxlength="10" class="input full-width" >
				</p>
				<p class="button-height inline-label">
					<label for="password" class="label">Confirme Senha<span class="red">*</span></label>
					<input type="password" name="password_confirmation" maxlength="10" class="input full-width" >
				</p>
			</div>
			<br>
			<p class="button-height align-center">
				<span class="button-group">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
					@can('model-admins-update')
						<button id="btn-modal" onclick="formAdmin('update')" class="button icon-publish blue-gradient"> Alterar </button>
					@endcan
				</span>
			</p>
		</fieldset>
	</form>
</div>
<!-- Mask -->
<script src="{{url('assets/backend/js/libs/Mask/jquery.maskedinput.js')}}"></script>

<script>
$( document ).ready(function() {
    $("#phone").mask("(99) 9999-9999?9");

    $("#reset-password").on('change', function() {
        $("#box-reset-password").toggle(this.checked);
    }).triggerHandler('change');
});
</script>