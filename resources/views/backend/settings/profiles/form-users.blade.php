<div id="modal-profiles">
	<form id="form-profiles" method="POST" action="{{route('profile.users.store', $data->id)}}" onsubmit="return false">	
		{{csrf_field()}}
			<p class="green underline margin-bottom">{{$title}} <br> {{$data->name}}</p>
			@if(count($users) == 1)
				<p class=" red margin-bottom">Todos já foram vinculados!</p>
			@else	
				@foreach($users as $user)
					@if($user->profile != 'Master')
						<p>
							<input class="checkbox" type="checkbox" name="users[]" id="checkbox-{{$user->id}}" value="{{$user->id}}|{{$user->name}}" > 
							<label for="checkbox-{{$user->id}}" class="label"> <strong>{{$user->name}}</strong></label>	
						</p>
					@endif
				@endforeach
			@endif
		<div class="align-center large-margin-top">
			<button onclick="fechaModal()"class="button">Cancelar</button>
			@if(count($users) >=2 )
				<button id="btn-modal" onclick="formUsers('create')" class="button blue-gradient">
					<span class="icon-outbox"></span> Salvar 
				</button>
			@endif
		</div>
	</form>
</div>