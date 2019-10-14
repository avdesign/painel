<div id="modal-profile-clients">
	<form id="form-profile-clients" method="POST" action="{{route('customers-perfil.update', $data->id)}}" onsubmit="return false">
		@method("PUT")
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="profile" class="label"> Perfil <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="{{$data->name}}">
			</p>
			<p class="button-height inline-label">
				<label for="percent_card" class="label"> Parcelado <span class="red">*</span></label>
				<span class="number input">
					<button type="button" class="button number-down">-</button>
						<input type="text" id="percent_card" name="percent_card" value="{{$data->percent_card}}" size="4" class="input-unstyled" data-number-options='{"min":0,"max":100,"increment":0.5,"shiftIncrement":5,"precision":0.25}'>
					<button type="button" class="button number-up">+</button>
				</span>
				<label for="label-percent_card" class="button blue-gradient">
					<i class="fa fa-percent" aria-hidden="true"></i>
				</label>
			</p>
			<p class="button-height inline-label">
				<label for="percent_cash" class="label"> À Vista <span class="red">*</span></label>
				<span class="number input">
					<button type="button" class="button number-down">-</button>
						<input type="text" id="percent_cash" name="percent_cash" value="{{$data->percent_cash}}" size="4" class="input-unstyled" data-number-options='{"min":0,"max":100,"increment":0.5,"shiftIncrement":5,"precision":0.25}'>
					<button type="button" class="button number-up">+</button>
				</span>
				<label for="label-percent_cash" class="button blue-gradient">
					<i class="fa fa-percent" aria-hidden="true"></i>
				</label>
			</p>
			<p class="button-height inline-label">
				<label for="sum" class="label">Calcular para:</label>
				<span class="button-group">
					<label for="sum-1" class="button blue-active">
						<input type="radio" name="sum" id="sum-1" value="+" @if($data->sum == '+') checked @endif>
						Mais
					</label>
					<label for="sum-0" class="button red-active">
						<input type="radio" name="sum" id="sum-0" value="-" @if($data->sum == '-') checked @endif>
						Menos
					</label>
				</span>
			</p>

			<p class="button-height inline-label">
				<label for="order" class="label">Ordem / Status</label>
				<span class="number input margin-right">
					<button type="button" class="button number-down">-</button>
					<input type="text" name="order" value="{{$data->order}}" class="input-unstyled order" size="3">
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
					@can('config-profile-client-update')
						<button id="btn-modal" onclick="formProfileClient('update')" class="button icon-	outbox blue-gradient"> 
						<span class="icon-publish"></span> Alterar 
						</button>
					@endcan
				</span>
			</p>
		</fieldset>
	</form>
</div>