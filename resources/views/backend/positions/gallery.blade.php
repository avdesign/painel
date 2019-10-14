<div id="data-positions-{{$idpro}}">
	<div class="block-title silver-gradient">
		<h3>
			<i class="fa fa-cog" aria-hidden="true"></i>
			<strong> {{$title_count}} </strong>
		</h3>
	</div>
	<div class="with-padding silver-gradient">
		@foreach($images as $image)
			<div class="list spaced">
				<div class="float-right">
					<span class="button-group compact align-right">
						<a href="javascript:void(0)"
						   onclick="abreModal('{{constLang('images.create')}}', '{{route('positions-product.create', $image->id)}}', 'form-positions', 2, 'true',800,780);"
						   class="button icon-camera blue-gradient glossy">{{constLang('add')}}
						</a>
					</span>
				</div>
				<h4 class="big-text blue underline">
					<strong> {{constLang('color')}}: {{$image->color}}</strong>

				</h4>
			</div>
			<ul id="gallery-positions-{{$image->id}}" class="gallery">
				@foreach($image->positions->sortBy('order') as $position)
					<li id="img-positions-{{$position->id}}">					
						<img src="{{url($path.$position->image)}}" class="framed">
						<div class="controls">
							@php
								($position->active == constLang('active_true') ? $col = 'green' : $col = 'red');
							@endphp
							<span id="btns-{{$position->id}}" class="button-group compact children-tooltip">
								<button id onclick="statusPosition('{{$position->id}}','{{route('status-position', $position->id)}}','{{$position->active}}','{{csrf_token()}}');" class="button icon-tick {{$col}}-gradient" title="{{constLang('status_change')}}"></button>
								<button onclick="abreModal('{{constLang('images.edit')}}', '{{route('positions-product.edit', ['idimg' => $position->image_color_id,'id' => $position->id])}}', 'form-positions', 2, 'true',800,780);" class="button" title="{{constLang('images.edit')}}">{{constLang('edit')}}</button>
								<button onclick="deletePosition('{{$position->id}}', '{{route('positions-product.destroy', ['idimg' => $position->image_color_id, 'id' => $position->id])}}');" class="button icon-trash red-gradient" title="{{constLang('images.delete')}}"></button>
							</span>
						</div>
					</li>
				@endforeach	
			</ul>
		@endforeach
	</div>
</div>