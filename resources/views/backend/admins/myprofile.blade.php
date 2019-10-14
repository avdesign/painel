<div id="modal-myprofile">
	<form id="form-myprofile" method="POST" action="{{route('admin.profile.update', $id)}}" onsubmit="return false">
		@method("PUT")
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="profile" class="label"> Perfil: </label>
				<strong> {{$data->profile}} </strong>&nbsp;&nbsp;&nbsp;&nbsp;
				@if($data->commission == 'Sim')
					<strong>  Comissão: {{$data->percent}}%</strong>
				@endif
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
			<div id="btn-add-photo-admin" style="display: @if($count == 0) block @else none @endif">
				<br>
				<p class="button-height inline-label">
					<label class="label"><strong>Adicionar Foto </strong></label>
					<button onclick="abreModal('Adicionar Foto', '{{route('photo-admin.create', $id)}}', 'form-image', 2, 'true', 500, 400);" class="button icon-camera blue-gradient glossy">Clique aqui</button>
				</p>
				<br>
			</div>

			<div id="btn-upd-photo-admin" style="display: @if($count == 1) block @else none @endif">
				<br>
				<p class="button-height inline-label">
					<label class="label"><strong>Alterar Foto </strong></label>
					<button onclick="abreModal('Adicionar Foto', '{{route('photo-admin.edit', ['id' => numLetter($id), 'file' => $file])}}', 'form-image', 2, 'true', 500, 400);" class="button icon-camera blue-gradient glossy">Clique aqui</button>
				</p>
				<br>
			</div>


			<p class="button-height align-center">
				<span class="button-group">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
					@can('model-admins-profile')
						<button id="btn-modal" onclick="formMyProfile('myprofile', 'Aguarde','Alterar',)" class="button icon-publish blue-gradient"> Alterar </button>
					@endcan
				</span>
			</p>
		</fieldset>
	</form>
</div>
<!-- Mask -->
<script src="{{mix('backend/js/libs/Mask/jquery.maskedinput.min.js')}}"></script>
<script src="{{mix('backend/scripts/admins/myprofile.min.js')}}"></script>


<script>
$(document).ready(function() {
    $("#phone").mask("(99) 9999-9999?9");

    $("#reset-password").on('change', function() {
        $("#box-reset-password").toggle(this.checked);
    }).triggerHandler('change');

});
</script>

