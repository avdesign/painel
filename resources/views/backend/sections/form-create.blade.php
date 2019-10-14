<div id="modal-sections">
	<form id="form-sections" method="POST" action="{{route('sections.store')}}" onsubmit="return false">
		@csrf
		<fieldset class="fieldset">
			<legend class="legend">Informações da Seção</legend>
			<p class="button-height inline-label">
				<label for="name" class="label"> Nome <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="tags" class="label"> Tags </label>
				<input type="text" name="tags" class="input full-width" value="">
			</p>

			@if($configModel->description == 1)
				<p class="button-height inline-label">
					<label for="description" class="label">Descrição <span class="red">*</span></label>
					<textarea name="description" class="input full-width" cols="50" rows="2"></textarea>
				</p>
			@endif


			<p class="button-height inline-label">
				<label for="active" class="label">Ordem / Status </label>
				<span class="number input margin-right">
					<button type="button" class="button number-down">-</button>
					<input type="text" name="order" value="" size="2" class="input-unstyled order">
					<button type="button" class="button number-up">+</button>
				</span>
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

			@if($configModel->img_featured == 1)
				<p class="button-height inline-label">
					<label for="status_featured" class="label">Status Destaque</label>
					<span class="button-group">
						<label for="active_featured-1" class="button blue-active">
							<input type="radio" name="active_featured" id="active_featured-1" value="{{constLang('active_true')}}" checked="">
							{{constLang('active_true')}}
						</label>
						<label for="active_featured-0" class="button red-active">
							<input type="radio" name="active_featured" id="active_featured-0" value="{{constLang('active_false')}}">
							{{constLang('active_false')}}
						</label>
					</span>
				</p>
			@endif

			@if($configModel->img_banner == 1)
				<p class="button-height inline-label">
					<label for="status_banner" class="label">Status Banner </label>
					<span class="button-group">
						<label for="active_banner-1" class="button blue-active">
							<input type="radio" name="active_banner" id="active_banner-1" value="{{constLang('active_true')}}" checked="">
							{{constLang('active_true')}}
						</label>
						<label for="active_banner-0" class="button red-active">
							<input type="radio" name="active_banner" id="active_banner-0" value="{{constLang('active_false')}}">
							{{constLang('active_false')}}
						</label>
					</span>
				</p>
			@endif
		</fieldset>

		<p class="button-height align-center">
			<span class="button-group">
				<button onclick="fechaModal()" class="button"> Cancelar </button>
				@can('section-create')
					<button id="btn-modal" onclick="formSection('create')" class="button icon-publish blue-gradient"> Salvar </button>
				@endcan
			</span>
		</p>		
	</form>
</div>
