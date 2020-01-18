<div class="block-title silver-gradient">
	<h3>
		<i class="fa fa-cog" aria-hidden="true"></i>
		<strong> {{$title}}</strong>
	</h3>
</div>
<div class="silver-gradient">
	<div class="with-padding">
		<form id="form-config-products" method="POST" action="{{route('config.products.update', $data->id)}}" onsubmit="return false">
			<div class="columns">
				<div class="six-columns twelve-columns-tablet">
					<fieldset class="fieldset">
						@method("PUT")
						@csrf
					    <legend class="legend">Padrão dos produtos</legend>

						<p class="button-height inline-label">
							<label for="price_default" class="label">Preço Padrão</label>
							<select name="price_default" class="select check-list">
								@foreach($profiles as $profile)
									<option value="{{$profile->name}}" @if($data->price_default == $profile->name) selected @endif>{{$profile->name}}</option>
								@endforeach
							</select>
						</p>
						<p class="button-height inline-label">
							<label for="config_prices" class="label">Valores</label>
							<select name="config_prices" class="select check-list">
								<option value="0" @if($data->config_prices == 0) selected @endif>Manual</option>
								<option value="1" @if($data->config_prices == 1) selected @endif>Por Perfil</option>
							</select>
						</p>
						<p class="button-height inline-label">
							<label for="view_prices" class="label">Visualizar Preço</label>
							<select name="view_prices" class="select check-list">
								<option value="0" @if($data->view_prices == 0) selected @endif>Visitante</option>
								<option value="1" @if($data->view_prices == 1) selected @endif>Cliente</option>
							</select>
						</p>
						<p class="button-height inline-label">
							<label for="price_profile" class="label">Preço por Perfil</label>
							<span class="button-group">
								<label for="price_profile-1" class="button green-active">
									<input type="radio" name="price_profile" id="price_profile-1" value="1" @if($data->price_profile == 1) checked @endif>
									Sim
								</label>
								<label for="price_profile-0" class="button red-active" >
									<input type="radio" name="price_profile" id="price_profile-0" value="0" @if($data->price_profile == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="cost" class="label">Valor Custo</label>
							<span class="button-group">
								<label for="cost-1" class="button green-active">
									<input type="radio" name="cost" id="cost-1" value="1" @if($data->cost == 1) checked @endif>
									Sim
								</label>
								<label for="cost-0" class="button red-active" >
									<input type="radio" name="cost" id="cost-0" value="0" @if($data->cost == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="stock" class="label">Estoque</label>
							<span class="button-group">
								<label for="stock-1" class="button green-active">
									<input type="radio" name="stock" id="stock-1" value="1" @if($data->stock == 1) checked @endif>
									Sim
								</label>
								<label for="stock-0" class="button red-active" >
									<input type="radio" name="stock" id="stock-0" value="0" @if($data->stock == 0) checked @endif>
									Não
								</label>
							</span>
						</p>

						<p class="button-height inline-label">
							<label for="qty_min" class="label">Estoque Mínimo</label>
							<span class="button-group">
								<label for="qty_min-1" class="button green-active">
									<input type="radio" onclick="formQtdStok('qty_min', '1')" name="qty_min" id="qty_min-1" value="1" @if($data->qty_min == 1) checked @endif>
									Sim
								</label>
								<label for="qty_min-0" onclick="formQtdStok('qty_min', '0')" class="button red-active" >
									<input type="radio" name="qty_min" id="qty_min-0" value="0" @if($data->qty_min == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<div id="qty_min" class="margin-bottom" style="display: @if($data->qty_min == 0) none @endif">
							<p class="button-height">
								<span class="input">
									<label for="pseudo-input-2" class="button green-gradient">Und-Kit </label>
									<input type="text" name="qty_min_unit" class="input-unstyled input-sep" placeholder="mínimo" value="{{$data->qty_min_unit}}"  maxlength="4" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 55px;">
									<input type="text" name="qty_min_kit" class="input-unstyled" placeholder="máximo" value="{{$data->qty_min_kit}}"  maxlength="4" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 55px;">
								</span>
							</p>
						</div>
						<p class="button-height inline-label">
							<label for="qty_max" class="label">Estoque Máximo</label>
							<span class="button-group">
								<label for="qty_max-1" class="button green-active">
									<input type="radio" onclick="formQtdStok('qty_max', '1')" name="qty_max" id="qty_max-1" value="1" @if($data->qty_max == 1) checked @endif>
									Sim
								</label>
								<label for="qty_max-0" class="button red-active" >
									<input type="radio" onclick="formQtdStok('qty_max', '0')" name="qty_max" id="qty_max-0" value="0" @if($data->qty_max == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<div id="qty_max" class="margin-bottom" style="display: @if($data->qty_max == 0) none @endif">
							<p class="button-height">
								<span class="input">
									<label for="pseudo-input-2" class="button green-gradient">Und-Kit </label>
									<input type="text" name="qty_max_unit" class="input-unstyled input-sep" placeholder="mínimo" value="{{$data->qty_max_unit}}"  maxlength="4" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 55px;">
									<input type="text" name="qty_max_kit" class="input-unstyled" placeholder="máximo" value="{{$data->qty_max_kit}}"  maxlength="4" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 55px;">
								</span>
							</p>
						</div>
						<p class="button-height inline-label">
							<label for="freight" class="label">Frete</label>
							<span class="button-group">
								<label for="freight-1" class="button green-active">
									<input type="radio" name="freight" id="freight-1" value="1" @if($data->freight == 1) checked @endif>
									Sim
								</label>
								<label for="freight-0" class="button red-active" >
									<input type="radio" name="freight" id="freight-0" value="0" @if($data->freight == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="kit" class="label">Vender Kits</label>
							<span class="button-group">
								<label for="kit-1" class="button green-active">
									<input type="radio" name="kit" id="kit-1" value="1" @if($data->kit == 1) checked @endif>
									Sim
								</label>
								<label for="kit-0" class="button red-active" >
									<input type="radio" name="kit" id="kit-0" value="0" @if($data->kit == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
                        <p class="button-height inline-label">
                            <label for="kit" class="label">Gerar Código</label>
                            <span class="button-group">
								<label for="code-1" class="button green-active">
									<input type="radio" name="code" id="code-1" value="1" @if($data->code == 1) checked @endif>
									Sim
								</label>
								<label for="code-0" class="button red-active" >
									<input type="radio" name="code" id="code-0" value="0" @if($data->code == 0) checked @endif>
									Não
								</label>
							</span>
                        </p>
						@can('webmaster-view')
							<p class="button-height inline-label">
								<label for="grids" class="label">Grades</label>
								<span class="button-group">
									<label for="grids-1" class="button green-active">
										<input type="radio" name="grids" id="grids-1" value="1" @if($data->grids == 1) checked @endif>
										Sim
									</label>
									<label for="grids-0" class="button red-active" >
										<input type="radio" name="grids" id="grids-0" value="0" @if($data->grids == 0) checked @endif>
										Não
									</label>
								</span>
							</p>
						@endcan
						<p class="button-height inline-label">
							<label for="colors" class="label">Fotos: Cores</label>
							<span class="button-group">
								<label for="colors-1" class="button green-active">
									<input type="radio" name="colors" id="colors-1" value="1" @if($data->colors == 1) checked @endif>
									Sim
								</label>
								<label for="colors-0" class="button red-active" >
									<input type="radio" name="colors" id="colors-0" value="0" @if($data->colors == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="positions" class="label">Fotos: Posições</label>
							<span class="button-group">
								<label for="positions-1" class="button green-active">
									<input type="radio" name="positions" id="positions-1" value="1" @if($data->positions == 1) checked @endif>
									Sim
								</label>
								<label for="positions-0" class="button red-active" >
									<input type="radio" name="positions" id="positions-0" value="0" @if($data->positions == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="group_colors" class="label">Grupo de Cores</label>
							<span class="button-group">
								<label for="group_colors-1" class="button green-active">
									<input type="radio" name="group_colors" id="group_colors-1" value="1" @if($data->group_colors == 1) checked @endif>
									Sim
								</label>
								<label for="group_colors-0" class="button red-active" >
									<input type="radio" name="group_colors" id="group_colors-0" value="0" @if($data->group_colors == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="reviews" class="label">Comentários</label>
							<span class="button-group">
								<label for="reviews-1" class="button green-active">
									<input type="radio" name="reviews" id="reviews-1" value="1" @if($data->reviews == 1) checked @endif>
									Sim
								</label>
								<label for="reviews-0" class="button red-active" >
									<input type="radio" name="reviews" id="reviews-0" value="0" @if($data->reviews == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="quickview" class="label">Olhada Rápida</label>
							<span class="button-group">
								<label for="quickview-1" class="button green-active">
									<input type="radio" name="quickview" id="quickview-1" value="1" @if($data->quickview == 1) checked @endif>
									Sim
								</label>
								<label for="quickview-0" class="button red-active" >
									<input type="radio" name="quickview" id="quickview-0" value="0" @if($data->quickview == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="wishlist" class="label">Lista de Desejo</label>
							<span class="button-group">
								<label for="wishlist-1" class="button green-active">
									<input type="radio" name="wishlist" id="wishlist-1" value="1" @if($data->wishlist == 1) checked @endif>
									Sim
								</label>
								<label for="wishlist-0" class="button red-active" >
									<input type="radio" name="wishlist" id="wishlist-0" value="0" @if($data->wishlist == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="compare" class="label">Comparação</label>
							<span class="button-group">
								<label for="compare-1" class="button green-active">
									<input type="radio" name="compare" id="compare-1" value="1" @if($data->compare == 1) checked @endif>
									Sim
								</label>
								<label for="compare-0" class="button red-active" >
									<input type="radio" name="compare" id="compare-0" value="0" @if($data->compare == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="countdown" class="label">Cronômetro</label>
							<span class="button-group">
								<label for="countdown-1" class="button green-active">
									<input type="radio" name="countdown" id="countdown-1" value="1" @if($data->countdown == 1) checked @endif>
									Sim
								</label>
								<label for="countdown-0" class="button red-active" >
									<input type="radio" name="countdown" id="countdown-0" value="0" @if($data->countdown == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="video" class="label">Video</label>
							<span class="button-group">
								<label for="video-1" class="button green-active">
									<input type="radio" name="video" id="video-1" value="1" @if($data->video == 1) checked @endif>
									Sim
								</label>
								<label for="video-0" class="button red-active" >
									<input type="radio" name="video" id="video-0" value="0" @if($data->video == 0) checked @endif>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-label">
							<label for="mini_colors" class="label">Miniaturas</label>
							<select name="mini_colors" class="select check-list">
								<option value="hexa" @if($data->mini_colors == 'hexa') selected @endif>Picker</option>
								<!--
								<option value="thumbs" @if($data->mini_colors == 'thumbs') selected @endif>Miniatura</option>
								<option value="crop" @if($data->mini_colors == 'crop') selected @endif>Crop</option>
								-->
							</select>
						</p>
					</fieldset>

				</div>
				<div class="six-columns twelve-columns-tablet">
					<h4 class="green underline">Observações</h4>
					<ol>
						<li><b>Preço do Perfil:</b> Preço relacionado ao perfil do cliente.</li>
						<li><b>Valores:</b> Os valores serão digitados manualmente ou pelo perfil do cliente.</li>
						<li><b>Custo:</b> Habilita  o campo para informar o custo do produto.</li>
						<li><b>Estoque:</b> Habilita  o modulo de controle de estoque.</li>
						<li><b>Estoque Mínimo:</b> Alerta o administrador que já está no limite mínimo.</li>
						<li><b>Estoque Máximo:</b> Alerta o administrador que já está no limite máximo.</li>
						<li><b>Frete:</b>  Habilita  o modulo de frete.</li>
						<li><b>Vender Kits:</b>  Habilita  o modulo de vendas por kits (caixa,kit,pacote etc.)</li>
						<li><b>Gerar Código:</b>  Habilita  gerar o código atutomático para os produtos</li>
						<li><b>Grades:</b> Habilita  o modulo das grades dos produtos.</li>
						<li><b>Fotos das Cores:</b> Habilita  inserir cores dos produtos.</li>
						<li><b>Fotos das Posições:</b> Habilita  inserir fotos de posições.</li>
						<li><b>Grupo de Cores:</b> Habilita  o modulo de grupo de cores.</li>
						<li><b>Comentários:</b> Possibilita que o cliente logado faça comentáros sobre o produto.<br>
							- O comentário só será publicado após permissão do administrador do sistema.
						</li>
						<li><b>Olhada Rápida:</b> Permite que o visitante tenha uma visão rápida dos produtos.</li>
						<li><b>Lista de Desejo:</b> Possibilita que o cliente logado adicione um produto em sua lista de desejos.</li>
						<li><b>Comparação:</b> Possibilita que o visitante faça uma comparação do produto.</li>
						<li><b>Cronômetro:</b> Cronômetro regressivo para os produtos em ofertas.<br>
							- Se o produto estiver em oferta, coloque o número de dias para a contagem regressiva.
							- O produto será desabilitado como oferta automaticamente.
						</li>
						<li><b>Video:</b> Habilita  o campo para informar o link do video.</li>
						<li><b>Miniaturas:</b> Opção do tipo das imagens em miniaturas.<br>
							- Picker: Selecionar cor predominante.<br><br>
							- Crop: Recortar parte da foto. <span class="tag red-bg">em breve</span><br><br>
							- Miniatura: Foto em miniatura.<span class="tag red-bg">em breve</span>
						</li>
					</ol>
					@can('config-product-update')
						<p class="button-height inline-label">
							<button onclick="postFormJson($(this.form).attr('id'));" class="button icon-publish blue-gradient"> Salvar</button>
						</p>
					@endcan
				</div>
			</div>
		</form>
	</div>
</div>
<script>function formQtdStok(id, opc){if(opc == 1){$("#"+id).show();}else{$("#"+id).hide();}}</script>
