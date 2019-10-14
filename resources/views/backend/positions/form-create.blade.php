<form id="form-positions" method="post" action="{{route('positions-product.store', $idpro)}}" enctype="multipart/form-data">
	@csrf
	<span id="insert_color">
		<!-- Jquery: Ao salvar uma cor adiciona o id da cor -->
		@isset($image)
			<input name="pos[image_color_id]" type="hidden" value="{{$image->id}}">
			<input name="pos[name]" type="hidden" value="{{$image->slug}}">
			<input name="pos[color]" type="hidden" value="{{$image->color}}">
			<input name="pos[code]" type="hidden" value="{{$image->code}}">
			<input name="ac" type="hidden" value="add">
		@else
			<input name="ac" type="hidden" value="create">
		@endif
	</span>

	<div class="columns">
		<div class="five-columns twelve-columns-tablet">
			<h4 class="green underline">Status/Ordem:</h4>
			<fieldset class="fieldset">
				<p class="button-height inline-small-label">
					<label for="active" class="label">Status <span class="red">*</span></label>
					<span class="button-group">
						<label for="active_1" class="button green-active">
							<input type="radio" name="pos[active]" id="active_1" value="{{constLang('active_true')}}" checked>
							{{constLang('active_true')}}
						</label>
						<label for="active_0" class="button red-active" >
							<input type="radio" name="pos[active]" id="active_0" value="{{constLang('active_false')}}">
							{{constLang('active_false')}}
						</label>
					</span>
				</p>
				<p class="button-height inline-small-label">
					<label for="order_position" class="label">Ordem <span class="red">*</span></label>
					<span class="number input margin-right">
						<button type="button" class="button number-down">-</button>
						<input type="text" name="pos[order]" value="" size="2" class="input-unstyled order">
						<button type="button" class="button number-up">+</button>
					</span>
				</p>
			</fieldset>

		</div>
		<div class="seven-columns twelve-columns-tablet">
			<h4 class="green underline">Tamanho {{$pixel->width}}x{{$pixel->height}} pixels</h4>
			<fieldset class="fieldset">
				<p class="button-height  block-label">
					<input type="file" name="file" id="upload_position" value="" class="file" onchange="preview_image('upload_position', 'preview_position', 200);"/>
				</p>
				<div id="preview_position" align="center"></div>
			</fieldset>
		</div>
	</div>
	<div id="submit-position" align="center">
		<button id="btn-position" type="submit" class="button glossy">
			Proximo
			<span  class="button-icon right-side"><span class="icon-forward"></span></span>
		</button>
	</div>
</form>