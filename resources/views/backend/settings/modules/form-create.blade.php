<div id="modal-modules">
	<form id="form-modules" method="POST" action="{{route('modules.store')}}" onsubmit="return false">
		@csrf
		<fieldset class="fieldset">
			<p class="button-height inline-label">
				<label for="name" class="label"> Modulo <span class="red">*</span></label>
				<input type="text" name="name" class="input full-width" value="">
			</p>
			<p class="button-height inline-label">
				<label for="name" class="label"> Tipo <span class="red">*</span></label>
				<span class="button-group">
					<label for="type-1" class="button green-active">
						<input type="radio" name="type" id="type-1" value="C" checked>C
					</label>
					<label for="type-2" class="button green-active">
						<input type="radio" name="type" id="type-2" value="A">A
					</label>
					<label for="type-3" class="button green-active">
						<input type="radio" name="type" id="type-3" value="R">R
					</label>
				</span>
			</p>

			<p class="button-height inline-label">
				<label for="label" class="label"> Descrição <span class="red">*</span></label>
				<textarea name="label" class="input full-width autoexpanding"></textarea>
			</p>
			<p class="button-height inline-label">
				<label for="order" class="label"> Ordem <span class="red">*</span></label>
				<span class="number input margin-right">
					<button type="button" class="button number-down">-</button>
					<input type="text" name="order" value="" size="2" class="input-unstyled order">
					<button type="button" class="button number-up">+</button>
				</span>
			</p>

			<p class="button-height align-center">
				<span class="button-group">
					<button onclick="fechaModal()" class="button"> Cancelar </button>
					@can('config-module-create')
						<button id="btn-modal" onclick="formModule('create')" class="button blue-gradient">
							<span class="icon-outbox"></span> Salvar
						</button>
					@endcan
				</span>
			</p>
		</fieldset>
	</form>
</div>


