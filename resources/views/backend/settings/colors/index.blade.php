<div class="block-title silver-gradient">
	<h3>
		<span class="icon icon-browser blue"></span>
		<strong class="blue"> Personalização das cores </strong>
	</h3>
</div>
<div class="silver-gradient">
	<div class="with-padding">
		<div class="columns">
			<div class="twelve-columns twelve-columns-tablet">
				<form id="form-config-frete" method="POST" action="{{route('config.colors.update')}}" onsubmit="return false">
					<input name="_method" type="hidden" value="PUT">
					{{csrf_field()}}
					<fieldset class="fieldset">
					    <legend class="legend">Personalização  das tabelas</legend>
						<p class="button-height inline-large-label">
							<label for="qty_page" class="label">Limite de carregamento por página</label>
							<span class="button-group">
								<label for="table_limit_1" class="button green-active">
									<input type="radio" name="table_limit" id="table_limit_1" value="10"@if($data->table_limit == 10) checked @endif>
									10
								</label>
								<label for="table_limit_2" class="button green-active">
									<input type="radio" name="table_limit" id="table_limit_2" value="20"@if($data->table_limit == 20) checked @endif>
									20
								</label>
								<label for="table_limit_3" class="button green-active">
									<input type="radio" name="table_limit" id="table_limit_3" value="30"@if($data->table_limit == 30) checked @endif>
									30
								</label>
								<label for="table_limit_4" class="button green-active">
									<input type="radio" name="table_limit" id="table_limit_4" value="40"@if($data->table_limit == 40) checked @endif>
									40
								</label>
								<label for="table_limit_5" class="button green-active">
									<input type="radio" name="table_limit" id="table_limit_5" value="50"@if($data->table_limit == 50) checked @endif>
									50
								</label>
							</span>					    
						</p>
						<p class="button-height inline-label">
							<label for="click" class="label">Click Detalhes</label>
							<select name="table_open_details" class="select">
								<option value="td.details-control"@if($data->table_open_details == 'td.details-control') selected @endif>Botão Lateral</option>
								<option value="tbody td"@if($data->table_open_details == 'tbody td') selected @endif>Linha Inteira</option>
							</select>
						</p>
						<p class="button-height inline-label">
						    <label for="table_color_sel" class="label">Selecionada<span class="red">*</span></label>
							<span class="input">
								<label onclick="colorTags('Preto','anthracite-gradient','table_color_sel', 'table_color_sel_id')" class="button black-gradient">
									<span class="small-margin-right"></span>
								</label>
								<label onclick="colorTags('Cinza Escuro','grey-gradient','table_color_sel', 'table_color_sel_id')" class="button grey-gradient">
									<span class="small-margin-right"></span>
								</label>
								<label onclick="colorTags('Vermelho','red-gradient','table_color_sel', 'table_color_sel_id')" class="button red-gradient">
									<span class="small-margin-right"></span>
								</label>
								<label onclick="colorTags('Laranja','orange-gradient','table_color_sel', 'table_color_sel_id')" class="button orange-gradient">
									<span class="small-margin-right"></span>
								</label>
								<label onclick="colorTags('Verde','green-gradient','table_color_sel', 'table_color_sel_id')" class="button green-gradient">
									<span class="small-margin-right"></span>
								</label>
								<label onclick="colorTags('Azul','blue-gradient','table_color_sel', 'table_color_sel_id')" class="button blue-gradient">
									<span class="small-margin-right"></span>
								</label>
								<input type="text" id="table_color_sel_id" class="input-unstyled" value="{{$data->table_color_sel}}" style="width: 80px;">
								<input type="hidden" name="table_color_sel" id="table_color_sel" value="{{$data->table_color_sel}}">
							</span>							
						</p>
						<p class="button-height inline-label">
						    <label for="table_color" class="label">Cor Tabelas <span class="red">*</span></label>
							<span class="input">
								<label onclick="colorTags('Preto','anthracite-gradient','table_color', 'table_color_id')" class="button black-gradient">
									<span class="small-margin-right"></span>
								</label>
								<label onclick="colorTags('Cinza Escuro','grey-gradient','table_color', 'table_color_id')" class="button grey-gradient">
									<span class="small-margin-right"></span>
								</label>
								<label onclick="colorTags('Vermelho','red-gradient','table_color', 'table_color_id')" class="button red-gradient">
									<span class="small-margin-right"></span>
								</label>
								<label onclick="colorTags('Laranja','orange-gradient','table_color', 'table_color_id')" class="button orange-gradient">
									<span class="small-margin-right"></span>
								</label>
								<label onclick="colorTags('Verde','green-gradient','table_color', 'table_color_id')" class="button green-gradient">
									<span class="small-margin-right"></span>
								</label>
								<label onclick="colorTags('Azul','blue-gradient','table_color', 'table_color_id')" class="button blue-gradient">
									<span class="small-margin-right"></span>
								</label>
								<input type="text" id="table_color_id" class="input-unstyled" value="{{$data->table_color}}" style="width: 80px;">
								<input type="hidden" name="table_color" id="table_color" value="{{$data->table_color}}">
							</span>
						</p>
						<p class="button-height inline-label">
							<button id="btn-color-table" onclick="postFormJson($(this.form).attr('id'));" class="button icon-publish blue-gradient"> Salvar </button>
						</p>
					</fieldset>
				</form>
			</div>	
		</div>
	</div>
</div>