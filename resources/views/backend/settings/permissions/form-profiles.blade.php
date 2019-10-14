<div id="modal-permissions">
	<form id="form-permissions" method="POST" action="{{route('permission.profile.store', $data->id)}}" onsubmit="return false">	
		{{csrf_field()}}
			<p class="green underline margin-bottom">{{$title}} <br> {{$data->name}}</p>
			@foreach($profiles as $profile) 
			    @if($profile->name != 'Master')
					<p>
						<input class="checkbox" type="checkbox" name="profiles[]" id="checkbox-{{$profile->id}}" value="{{$profile->id}}|{{$profile->name}}" > 
						<label for="checkbox-{{$profile->id}}" class="label"> <strong>{{$profile->name}}</strong></label>	
					</p>
				@endif
			@endforeach
		<div class="align-center large-margin-top">
			<button onclick="fechaModal()"class="button">Cancelar</button>
			@if(count($profiles) >=1 )
				<button id="btn-modal" onclick="formProfiles('create')" class="button blue-gradient">
					<span class="icon-outbox"></span> Salvar 
				</button>
			@endif
		</div>
	</form>
</div>