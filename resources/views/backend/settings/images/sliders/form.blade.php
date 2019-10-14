<div class="block-title silver-gradient">
	<h3>
		<i class="fa fa-cog" aria-hidden="true"></i>
		<strong> {{$title}} </strong>
	</h3>
</div>
<div class="silver-gradient">
	<div class="with-padding">
		<form id="form-config-sliders" method="POST" action="{{route('config.slider.update', $data->id)}}" onsubmit="return false">
			@method("PUT")
			@csrf
			<fieldset class="fieldset">
				<legend class="legend">Padrão do Slider</legend>
				<p class="button-height inline-label">
					<label for="colunas" class="label">Status<span class="red">*</span></label>
					<span class="button-group">
						<label for="status-1" class="button green-active">
							<input type="radio" name="status" id="status-1" value="1" @if($data->status == 'Ativo') checked @endif>
							Sim
						</label>
						<label for="status-2" class="button green-active">
							<input type="radio" name="status" id="status-2" value="0" @if($data->status == 'Inativo') checked @endif>
							Não
						</label>
					</span>
				</p>

				<p class="button-height inline-label">
					<label for="img_default" class="label">Tempo (delay) </label>
					<input type="number" name="delay" class="input" value="{{$data->delay}}">
				</p>

				<p class="button-height">
					<span class="input">
						<label for="pseudo-input-1" class="button blue-gradient">Tamanho Modal</label>
						<input type="number" name="width_modal" class="input-unstyled input-sep" placeholder="Largura" maxlength="3" value="{{$data->width_modal}}" style="width: 80px;">
						<input type="number" name="height_modal" class="input-unstyled" placeholder="Altura" maxlength="3" value="{{$data->height_modal}}" style="width: 80px;">
					</span>							
				</p>
			</fieldset>

			<fieldset class="fieldset">
			    <legend class="legend">Padrão das Imagens</legend>
				<p class="button-height inline-label">
					<label for="path" class="label">Pasta <span class="red">*</span></label>
					<input type="text" name="path" class="input full-width" value="{{$data->path}}">
				</p>
				<p class="button-height inline-label">
					<label for="image" class="label">Imagem <span class="red">*</span></label>
					<span class="input">
						<input type="number" name="width" class="input-unstyled input-sep" placeholder="Largura" maxlength="3" value="{{$data->width}}" style="width: 80px;">
						<input type="number" name="height" class="input-unstyled" placeholder="Altura" maxlength="3" value="{{$data->height}}" style="width: 80px;">
					</span>
				</p>
				<p class="button-height inline-label">
					<label for="thumb" class="label">Miniatura <span class="red">*</span></label>
					<span class="input">
						<input type="number" name="width_thumb" class="input-unstyled input-sep" placeholder="Largura" maxlength="4" value="{{$data->width_thumb}}" style="width: 80px;">
						<input type="number" name="height_thumb" class="input-unstyled" placeholder="Altura" maxlength="3" value="{{$data->height_thumb}}" style="width: 80px;">
					</span>							
				</p>
					@can('config-slider-update')
						<p class="button-height inline-label">
							<button onclick="postFormJson($(this.form).attr('id'));" class="button icon-publish blue-gradient"> Salvar</button>
						</p>
					@endcan
				</fieldset>
		</form>
	</div>
</div>