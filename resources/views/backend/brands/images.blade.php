<div class="block" id="image-brand-{{$id}}">
    <div class="block-title silver-gradient">
        <h4><span class="icon icon-camera"></span> {{$title}}</h4>
        @can('brand-images-create')
	        <div class="button-group absolute-right compact">
	            <a href="javascript:void(0)" onclick="abreModal('{{$upload['btn']['create']}}: {{$upload['type']}}', '{{route($upload['type'].'-brand.create', $id)}}', 'form-image', 2, 'true', 500, 400);" class="button icon-plus-round blue-gradient glossy">{{$upload['btn']['create']}}
				</a>
	        </div>
	    @endcan
    </div>
    <div class="with-padding">
		<ul id="gallery-{{$id}}" class="gallery">
		    @foreach($data as $file)
		    	@if($upload['type'] == $file->type)
					<li class="rectangle" id="img-{{$file->id}}">
						<img src="{{url($upload['photo_url'].$file->image)}}" class="framed">
						<div class="controls">
							<span id="btns-{{$file->id}}" class="button-group compact children-tooltip">
								@if($file->active == constLang('active_true'))
									<button id="status-{{$file->id}}" onclick="statusImage('{{$file->id}}', '{{route($file->type.'-brand.status', $file->id)}}', '{{csrf_token()}}')" class="button icon-tick green-gradient" title="{{$upload['btn']['status']}}"></button>
								@else
									<button id="status-{{$file->id}}" onclick="statusImage('{{$file->id}}', '{{route($file->type.'-brand.status', $file->id)}}', '{{csrf_token()}}')" class="button icon-tick red-gradient" title="{{$upload['btn']['status']}}"></button>
								@endif
								<button id="edit-{{$file->id}}" onclick="abreModal('Editar: {{$file->type}}', '{{route($file->type.'-brand.edit', ['$id' => $id, 'file' => $file->id])}}', 'form-image', 2, 'true', 500, 400);" class="button" title="{{$upload['btn']['edit']}}">{{$upload['btn']['edit']}}</button>
								<button id="delete-{{$file->id}}" onclick="deleteImage('{{$file->id}}', '{{route($file->type.'-brand.destroy', ['id' => $id, 'file' => $file->id])}}', '{{csrf_token()}}')" class="button icon-trash red-gradient" title="{{$upload['btn']['delete']}}"></button>
							</span>
						</div>
					</li>
				@endif
			@endforeach
		</ul>
	</div>    
</div>