<div class="block large-margin-bottom">
	<div class="block-title">
		<h3><span class="icon icon-publish"></span> {{$config['title_index']}}</h3>
		@can('config-site-create')
			<div class="button-group absolute-right compact">
				<button onclick="abreModal('{{$config['title_page']}}', '{{route('page-site.create')}}', 'page', 2, true, 240, 340)"
						title="{{$config['title_page']}}"
						class="button icon-plus-round with-tooltip anthracite-gradient">{{$config['text_page']}}
				</button>
				<button onclick="abreModal('{{$config['title_model']}}', '{{route('template-site.create')}}', 'template', 2, true, 240, 340)"
						title="{{$config['title_model']}}"
						class="button icon-plus-round with-tooltip anthracite-gradient">{{$config['text_model']}}
				</button>
			</div>
		@endcan
	</div>

		<div class="with-padding" id="load-template">

			@foreach($pages as $page)
				<div id="content-{{$page->id}}">
					<div class="button-group float-right">
						<a href="javascript:deletePage('{{$page->id}}','{{route('page-site.destroy', $page->id)}}','{{ csrf_token() }}')"
						   class="button icon-trash confirm red">
						</a>
						<button onclick="abreModal('{{$config['edit_page']}} {{$page->name}}', '{{route('page-site.show', $page->id)}}', 'page', 2, true, 240, 300);" class="button icon-pencil">Editar</button>
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
		</div>
</div>
<script src="{{mix('backend/scripts/settings/template.min.js')}}"></script>

