<div class="block-title silver-gradient">
	<h3>
		<i class="fa fa-cog" aria-hidden="true"></i>
		<strong> {{$title}} </strong>
	</h3>
</div>
<div class="silver-gradient">
	<div class="with-padding">
		<form id="form-config-brands" method="POST" action="{{route('config.images-admin.update', $data->id)}}" onsubmit="return false">
			@method("PUT")
			@csrf

			<fieldset class="fieldset">
			    <legend class="legend">Padrão da Foto</legend>
				<p class="button-height inline-label">
					<label for="path" class="label">Pasta <span class="red">*</span></label>
					<input type="text" name="path" class="input full-width" value="{{$data->path}}">
				</p>

				<p class="button-height inline-label">
					<label for="width_photo" class="label">Largura <span class="red">*</span></label>
					<input type="number" name="width_photo" class="input" value="{{$data->width_photo}}" placeholder="Largura" maxlength="3" style="width: 80px;">
				</p>

				<p class="button-height inline-label">
					<label for="height_photo" class="label">Altura <span class="red">*</span></label>
					<input type="number" name="height_photo" class="input" value="{{$data->height_photo}}" placeholder="Altura" maxlength="3" style="width: 80px;">
				</p>
				@can('config-brand-update')
					<p class="button-height inline-label">
						<button onclick="postFormJson($(this.form).attr('id'));" class="button icon-publish blue-gradient"> Salvar</button>
					</p>
				@endcan
			</fieldset>
		</form>
	</div>
</div>