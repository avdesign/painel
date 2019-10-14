<div class="block-title silver-gradient">
	<h3>
		<i class="fa fa-cog" aria-hidden="true"></i>
		<strong> {{$title}} </strong>
	</h3>
</div>
<div class="silver-gradient">
	<div class="with-padding">
		<form id="form-config-products" method="POST" action="{{route('config.freight.update', $data->id)}}" onsubmit="return false">
			<div class="columns">
				<div class="six-columns twelve-columns-tablet">
					<input name="_method" type="hidden" value="PUT">
					@csrf
					<fieldset class="fieldset">
					    <legend class="legend">Padrão dos correios</legend>

						<p class="button-height inline-label">
							<label for="default" class="label">Padrão <span class="red">*</span></label>
							<select name="default" id="default" class="select">
								<option value="1" @if($data->default == 1) selected @endif> {{constLang('active_true')}} </option>
								<option value="0" @if($data->default == 0) selected @endif> {{constLang('active_false')}} </option>
							</select>
						</p>

						<p class="button-height inline-label">
							<label for="distribute_box" class="label">Distribuição <span class="red">*</span></label>
							<select name="distribute_box" id="distribute_box" class="select">
								<option value="1" @if($data->distribute_box == 1) selected @endif> {{constLang('active_true')}} </option>
								<option value="0" @if($data->distribute_box == 0) selected @endif> {{constLang('active_false')}} </option>
							</select>
						</p>


						<p class="button-height inline-label">
							<label for="weight" class="label">Peso <span class="red">*</span></label>
							<span class="button-group">
								<label for="radio-0" class="button green-active">
									<input type="radio" name="weight" id="radio-0" value="1" @if($data->weight == 1) checked @endif>
									Sim
								</label>
								<label for="radio-1" class="button red-active" >
									<input type="radio" name="weight" id="radio-1" value="0" @if($data->weight == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="width" class="label">Largura <span class="red">*</span></label>
							<span class="button-group">
								<label for="radio-2" class="button green-active">
									<input type="radio" name="width" id="radio-2" value="1" @if($data->width == 1) checked @endif>
									Sim
								</label>
								<label for="radio-3" class="button red-active" >
									<input type="radio" name="width" id="radio-3" value="0" @if($data->width == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="altura" class="label">Altura <span class="red">*</span></label>
							<span class="button-group">
								<label for="radio-4" class="button green-active">
									<input type="radio" name="height" id="radio-4" value="1" @if($data->height == 1) checked @endif>
									Sim
								</label>
								<label for="radio-5" class="button red-active" >
									<input type="radio" name="height" id="radio-5" value="0" @if($data->height == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="length" class="label">Comprimento <span class="red">*</span></label>
							<span class="button-group">
								<label for="radio-6" class="button green-active">
									<input  type="radio" name="length" id="radio-6" value="1" @if($data->length == 1) checked @endif>
									Sim
								</label>
								<label for="radio-7" class="button red-active" >
									<input type="radio" name="length" id="radio-7" value="0" @if($data->length == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="width" class="label">Declarar Valor <span class="red">*</span></label>
							<span class="button-group">
								<label for="radio-8" class="button green-active">
									<input type="radio" name="declare" id="radio-8" value="1" @if($data->declare == 1) checked @endif>
									Sim
								</label>
								<label for="radio-9" class="button red-active" >
									<input type="radio" name="declare" id="radio-9" value="0" @if($data->declare == 0) checked @endif>
									Não
								</label>
							</span>
						</p>

					@can('config-freight-update')
							<p class="button-height inline-label">
								<button onclick="postFormJson($(this.form).attr('id'));" class="button icon-publish blue-gradient"> Salvar </button>
							</p>
						@endcan
					</fieldset>
				</div>
				<div class="six-columns twelve-columns-tablet">
					<h4 class="green underline">Observações</h4>
					<ol>
						<li>Padrão Ativo: Os campos serão obrigatórios.</li>
						<li>Padrão Inativo: O frete não sera obrigatório.</li>
						<li>Distribuição: Ativo: Distribui os produtos de uma embalagem para outras padrão.</li>
						<li>Distribuição: Inativo: Mantêm os produtos na mesma embalagem. </li>
						<li>Sim: Os campos serão obrigatórios.</li>
						<li>Não: Os campos não serão obrigatórios.</li>
						<li>Declarar Valor: (Individual) Declara o valor do produto para receber o reembolso no caso de extravio.</li>
					</ol>

					<h4 class="green underline">Largura / Altura / Comprimento (cm)</h4>
					<p>Correio: A soma Largura + Altura + Comprimento não pode ultrapassar de 200 cm </p>
					@foreach($boxes as $boxe)
						<p class="button-height">
							<span class="input">
								<input type="text" name="box[{{$boxe->id}}][width]" class="input-unstyled input-sep" placeholder="Largura" value="{{$boxe->width}}" onKeyDown="javascript: return maskValor(this,event,3);" maxlength="3" style="width: 50px;">
								<input type="text" name="box[{{$boxe->id}}][height]" class="input-unstyled input-sep" placeholder="Altura" value="{{$boxe->height}}" onKeyDown="javascript: return maskValor(this,event,3);" maxlength="3" style="width: 50px;">
								<input type="text" name="box[{{$boxe->id}}][length]" class="input-unstyled" placeholder="Comprimento" onKeyDown="javascript: return maskValor(this,event,3);" value="{{$boxe->length}}" style="width: 50px;">
								<label for="pseudo-input-2" class="button blue-gradient">
									<span class="small-margin-left">{{$boxe->width + $boxe->height + $boxe->length}} cm</span>
								</label>
							</span>
						</p>
					@endforeach
				</div>

			</div>
		</form>
	</div>
</div>