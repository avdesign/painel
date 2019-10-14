<h4 class="blue underline">Tamanho {{$upload['width']}}x{{$upload['height']}} pixels</h4>
<div class="columns">
	<form id="form-image"  method="post" action="{{route('banner.update', ['type' => $type, 'id' => $data->id] )}}" class="columns" enctype="multipart/form-data">
		<input type="hidden" id="ac" name="ac" value="update">
		<input type="hidden" name="type" value="{{$type}}">
		<input type="hidden" name="active" value="{{$data->active}}">
		<input type="hidden" name="order" value="{{$data->order}}">
		@method("PUT")
		@csrf
	    <div class="eight-columns">
	    	<p class="button-height">
				<input type="file" name="image" id="upload_file" value="" class="file" onchange="preview_image('{{$id}}', '60%');" multiple/>
			</p>
	    </div>
	    <div class="new-row twelve-columns">
	    	<div class="align-center">
				<p id="image_preview_{{$id}}"><img src="{{url($upload['photo_url'].$data->image)}}" width="60%"></p>
			</div>
			@can('images-site-update')
		        <div id="btn-upload-submit" class="align-center display-none">
					<p class="button-height align-center">
						<button type="submit" id="btn-upload" class="button icon-cloud-upload blue-gradient display-none"> Upload </button>
					</p>
		        </div>
		    @endcan                       
	    </div>
	</form>
</div>

<script src="{{url('assets/backend/js/libs/formData/jquery.form.js')}}"></script>
