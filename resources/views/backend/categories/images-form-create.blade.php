<h4 class="blue underline">Tamanho {{$upload['width']}}x{{$upload['height']}} pixels</h4>
<div class="columns">
	<form id="form-image"  method="post" action="{{route($upload['type'].'-category.store', $id)}}" class="columns" enctype="multipart/form-data" return false>
		<input type="hidden" id="ac" name="ac" value="create">
		<input type="hidden" name="type" value="{{$upload['type']}}">
		<input type="hidden" name="category_id" value="{{$id}}">
		@csrf
		<div class="four-columns">
			<p class="button-height">
				<span class="button-group">
					<label for="active-1" class="button blue-active">
						<input type="radio" name="active" id="active-1" value="{{constLang('active_true')}}" checked>
						{{constLang('active_true')}}
					</label>
					<label for="active-0" class="button red-active">
						<input type="radio" name="active" id="active-0" value="{{constLang('active_false')}}">
						{{constLang('active_false')}}
					</label>
				</span>
			</p>
		</div>
	    <div class="eight-columns">
	    	<p class="button-height">
				<input type="file" name="image" id="upload_file" value="" class="file" onchange="preview_image('{{$id}}', '50%');" multiple/>
			</p>
	    </div>
	    <div class="new-row twelve-columns">
	    	<div class="align-center">
				<p id="image_preview_{{$id}}"></p>
			</div>
			@can('category-images-create')
		        <div id="btn-upload-submit" class="align-center display-none">
					<p class="button-height align-center">						
						<button type="submit" id="btn-upload" class="button icon-cloud-upload blue-gradient display-none"> Upload </button>						
					</p>
		        </div>
		    @endcan                       
	    </div>
	</form>
</div>
<script src="{{mix('backend/js/libs/formData/jquery.form.min.js')}}"></script>
