<div class="block-title silver-gradient">
	<h3>
		<i class="fa fa-cog" aria-hidden="true"></i>
		<strong> {{$title}} </strong>
	</h3>
</div>
<div class="silver-gradient">
	<div class="with-padding">
		<form id="form-config-banners" method="POST" action="{{route('config.banners.update', $data->id)}}" onsubmit="return false">
			@method("PUT")
			@csrf
			<input type="hidden" name="type" value="four">
			<fieldset class="fieldset">
				<legend class="legend">Padrão do Banner</legend>

				<p class="button-height inline-label">
					<label for="type" class="label">Tipo<span class="red">*</span></label>
					<select class="select check-list" name="type">
						<option value="four">Home Padrão</option>
					</select>
				</p>
				<p class="button-height inline-label">
					<label for="status" class="label">Status<span class="red">*</span></label>
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
				@can('config-banners-update')
					<p class="button-height inline-label">
						<button onclick="postFormJson($(this.form).attr('id'));" class="button icon-publish blue-gradient"> Salvar</button>
					</p>
				@endcan
				</fieldset>
		</form>
	</div>
</div>