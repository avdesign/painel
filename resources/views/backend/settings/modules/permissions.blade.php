<div class="with-padding">
	<div class="columns">
		<div class="twelve-columns">
			<ul class="list spaced">
				@forelse($ativos as $a)
					<li id="id_{{$data->id.$a->id}}">
						<a href="javascript:void(0)" class="list-link">						
							<strong><span class="icon-right-thin"> </span> {{$a->name}}</strong> <br>
							<span class="icon-level-down black">&nbsp;</span>
							<span class="blue"> {{$a->label}} </span>
						</a>
					</li>
				@empty
					<li class="align-center"><strong>Não existe permissões para este modulo!</strong></li>
				@endforelse
			</ul>
		</div>
	</div>
</div>