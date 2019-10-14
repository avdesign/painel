<div class="float-right">
	@can('config-permission-create')
		<button 
			onclick="abreModal('Adicionar Perfil: {{$data->perfil}}', '{{route('permission.profile.create', $data->id)}}', 'permissions', 3, true, '200', 300)"
			class="button anthracite-gradient icon-add-user">Adicionar
		</button>
	@endcan
</div>


<div class="with-padding">

	<div class="columns">

		<div class="twelve-columns">
			<ul id="id_{{$data->id}}" class="list spaced">
				@forelse($active as $val)				
					<li id="id_{{$data->id.$val->id}}">
						<a href="javascript:void(0)" class="list-link icon-user">
							<strong>{{$val->name}}</strong><br>
							<span class="icon-level-down black">&nbsp;</span>
							{{$val->label}}
						</a>
						<div class="button-group absolute-right compact show-on-parent-hover">
						@can('config-permission-delete')
								<button onclick="removePerfil('{{route('permission.profile.delete',[$data->id, $val->id])}}','{{$data->id.$val->id}}','{{$val->name}}')" class="button red-gradient icon-trash with-tooltip" title="{{$val->name}}">Excluir</button>
						@endcan
						</div>
					</li>
				@empty
					<li class="align-center"><strong>Não existe perfil com esta permissão!</strong></li>
				@endforelse
			</ul>
		</div>
	</div>
</div>


