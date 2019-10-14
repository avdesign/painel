<div id="modal-keywords">
	<form id="form-keywords" method="POST" action="{{route('keywords.update', $data->id)}}" onsubmit="return false">
		@method("PUT")
		@csrf
		<fieldset class="fieldset">
			<legend class="legend">Palavras Chaves (separadas por vírgula)</legend>
			<p class="button-height inline-label">
				<label for="title" class="label">Titulo <span class="red">*</span></label>
				<input type="text" name="title" class="input full-width" value="{{$data->title}}" >
			</p>
			<p class="button-height inline-label">
				<label for="genders" class="label">Gêneros <span class="red">*</span></label>
				<textarea name="genders" class="input full-width" cols="50" rows="2">{{$data->genders}}</textarea>
			</p>
			<p class="button-height inline-label">
				<label for="categories" class="label">Categorias <span class="red">*</span></label>
				<textarea name="categories" class="input full-width" cols="50" rows="2">{{$data->categories}}</textarea>
			</p>
			<p class="button-height inline-label">
				<label for="description" class="label">Descrição <span class="red">*</span></label>
				<textarea name="description" class="input full-width" cols="50" rows="2">{{$data->description}}</textarea>
			</p>
			<p class="button-height inline-label">
				<label for="keywords" class="label">Tags <span class="red">*</span></label>
				<textarea name="keywords" class="input full-width" cols="50" rows="2">{{$data->keywords}}</textarea>
			</p>
			<p class="button-height inline-label">
				<label for="active" class="label">Status</label>
				<span class="button-group">
					<label for="active-1" class="button blue-active">
						<input type="radio" name="active" id="active-1" value="{{constLang('active_true')}}" @if($data->active == constLang('active_true')) checked @endif>
						{{constLang('active_true')}}
					</label>
					<label for="active-0" class="button red-active">
						<input type="radio" name="active" id="active-0" value="{{constLang('active_false')}}" @if($data->active == constLang('active_false')) checked @endif>
						{{constLang('active_false')}}
					</label>
				</span>
			</p>

			<p class="button-height align-center">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
				<span class="button-group">
					@can('config-keyword-update')
						<button id="btn-modal" onclick="formKeywords('update')" class="button icon-	outbox blue-gradient"> 
						<span class="icon-publish"></span> Alterar 
						</button>
					@endcan
				</span>
			</p>
		</fieldset>
	</form>
</div>
