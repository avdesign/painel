<div class="block" id="image-admin-{{$id}}">
    <div class="block-title silver-gradient">
        <h4><span class="icon icon-camera"></span> {{$title}}</h4>
        @can('model-admins-update')
			<!-- Se já exite uma imagem display:none-->
			<div class="button-group absolute-right compact" style="display: @if($count == 0) block @else none @endif">
				<a id="btn-add-image-admin" href="javascript:void(0)" onclick="abreModal('{{$upload['btn']['create']}}: Foto', '{{route('photo-admin.create', $id)}}', 'form-image', 2, 'true', 500, 400);" class="button icon-plus-round blue-gradient glossy">{{$upload['btn']['create']}}
				</a>
			</div>
	    @endcan
    </div>
    <div class="with-padding">
		<ul id="gallery-{{$id}}" class="gallery">
		    @foreach($data as $file)
				<li id="img-{{$id}}">
					<img src="{{asset($upload['photo_url'].$file->image)}}" class="framed">
					<div class="controls">
						<span id="btns-{{$file->id}}" class="button-group compact children-tooltip">
							<button id="delete-{{$file->id}}"
									onclick="deleteImage('{{$id}}', '{{route('photo-admin-excluded', $file->id)}}', '{{csrf_token()}}')"
									class="button icon-trash red-gradient" title="{{$upload['btn']['delete']}}">Excluir</button>
						</span>
					</div>
				</li>
			@endforeach
		</ul>
	</div>    
</div>

