<div id="modal-config-images">
	<form id="form-config-images" method="POST" action="{{route('colors-positions.update', $data->id)}}" onsubmit="return false">
		@method('PUT')
		@csrf
		<fieldset class="fieldset">
			<legend class="legend">Tipo: Largura - Altura (pixels)</legend>
			<p><strong class="blue">Obrigátorio os padrões Thumbs e Normal</strong></p>
			<p class="button-height">
				<span class="input">
					<label for="pseudo-input-2" class="button blue-gradient">
						<span class="icon-camera small-margin-right"></span>
					</label>
					<select name="type" class="select compact expandable-list" style="width: 100px">
						<option value="C" @if($data->type == 'C') selected @endif>Cores</option>
						<option value="P" @if($data->type == 'P') selected @endif>Posições</option>
					</select>

					<input type="number" name="width" class="input-unstyled input-sep" placeholder="Largura" value="{{$data->width}}" maxlength="3" style="width: 80px;">

					<input type="number" name="height" class="input-unstyled" placeholder="Altura" value="{{$data->height}}" style="width: 80px;">
				</span>
			</p>
			<p class="button-height block-label">
				<label for="path" class="label">
					<small>Ex: imagens/produtos/1200x1200/</small>
					Pasta <span class="red">*</span>
				</label>
				<input type="text" name="path" class="input full-width" value="{{$data->path}}">
			</p>

			<p class="button-height inline-small-label">
				<label for="default" class="label">Padrão <span class="red">*</span></label>
				<select name="default" class="select compact expandable-list" style="width: 100px">
					<option value="T"@if($data->default == 'T') selected @endif>Thumbs</option>
					<option value="P"@if($data->default == 'P') selected @endif>Pequena</option>
					<option value="N"@if($data->default == 'N') selected @endif> Normal</option>
					<option value="M"@if($data->default == 'M') selected @endif>Média</option>
					<option value="G"@if($data->default == 'G') selected @endif>Grande</option>
					<option value="Z"@if($data->default == 'Z') selected @endif>Zoom</option>
				</select>
			</p>

			<p class="button-height align-center">
				<span class="button-group">
					<button onclick="fechaModal()" class="button"> Cancelar </button>
					@can('config-image-product-update')
						<button id="btn-modal" onclick="formConfigImage('update')" class="button icon-	outbox blue-gradient"> 
							<span class="icon-publish"></span> Alterar
						</button>
					@endcan
				</span>
			</p>
		</fieldset>
	</form>
</div>
