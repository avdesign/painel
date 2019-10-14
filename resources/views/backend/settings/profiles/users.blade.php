<div class="float-right">
	<button 
		onclick="abreModal('Adicionar Usuário: {{$data->perfil}}', '{{route('profile.users.create', $data->id)}}', 'perfis', 3, true, '200', 300)"
		class="button anthracite-gradient icon-add-user">Adicionar
	</button>
</div>

<div class="with-padding">

	<div class="columns">

		<div class="twelve-columns">
			<ul id="id_{{$data->id}}" class="list spaced">
				@forelse($active as $val)
					<li id="id_{{$data->id.$val->id}}">
						<a href="javascript:void(0)" class="list-link icon-user">
							<strong>{{$val->name}}</strong> {{$val->profile}}
						</a>
						<div class="button-group absolute-right compact show-on-parent-hover">
							<button onclick="deleteUsers('{{route('profile.users.delete',[$data->id, $val->id])}}','{{$data->id.$val->id}}','{{$val->name}}')" class="button red-gradient icon-trash with-tooltip" title="Excluir {{$val->name}}">Excluir</button>
						</div>
					</li>
				@empty
					<li class="align-center"><strong>Não existe usuáro com este perfil!</strong></li>
				@endforelse
			</ul>
		</div>
	</div>
</div>


