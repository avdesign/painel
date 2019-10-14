@foreach($pages as $page)
	<div id="content-{{$page->id}}">
		<div class="button-group float-right">
			<a href="javascript:deletePage('{{$page->id}}','{{route('page-site.destroy', $page->id)}}','{{ csrf_token() }}')"
			   class="button icon-trash confirm red">
			</a>
			<button onclick="abreModal('{{$config['edit_model']}} {{$page->name}}', '{{route('page-site.show', $page->id)}}', 'page', 2, true, 240, 300);" class="button icon-pencil">Editar</button>
		</div>
		<h4 class="blue underline">{{$page->name}}</h4>
		<p class="button-height">
			<span class="button-group">
				@foreach($page->modules as $mod)
					@if($mod->active == constLang('active_false'))
						<button id="btn-mod-{{$mod->id}}" onclick="abreModal('{{$config['edit_model']}} {{$mod->name}}', '{{route('template-site.show', $mod->id)}}', 'page', 2, true, 240, 340);"  class="button margin-top">{{$mod->name}}
							<span class="count red-gradient">{{$mod->tmp}}</span>
						</button>
					@else
						@if ($mod->tmp == 1)
							<button id="btn-mod-{{$mod->id}}" onclick="abreModal('{{$config['edit_model']}} {{$mod->name}}', '{{route('template-site.show', $mod->id)}}', 'page', 2, true, 240, 340);"  class="button margin-top">{{$mod->name}}
								<span class="count blue-gradient">{{$mod->tmp}}</span>
							</button>
						@elseif ($mod->tmp == 2)
							<button id="btn-mod-{{$mod->id}}" onclick="abreModal('{{$config['edit_model']}} {{$mod->name}}', '{{route('template-site.show', $mod->id)}}', 'page', 2, true, 240, 340);"  class="button margin-top">{{$mod->name}}
								<span class="count orange-gradient">{{$mod->tmp}}</span>
							</button>
						@elseif ($mod->tmp == 3)
							<button id="btn-mod-{{$mod->id}}" onclick="abreModal('{{$config['edit_model']}} {{$mod->name}}', '{{route('template-site.show', $mod->id)}}', 'page', 2, true, 240, 340);"  class="button margin-top">{{$mod->name}}
								<span class="count green-gradient">{{$mod->tmp}}</span>
							</button>
						@endif
					@endif
				@endforeach
			</span>
		</p>
	</div>
@endforeach






