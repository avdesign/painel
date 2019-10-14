<div class="block-title silver-gradient">
	<h3>
		<i class="fa fa-cog" aria-hidden="true"></i>
		<strong> {{$title}}</strong>
	</h3>
</div>
<div class="silver-gradient">
	<div class="with-padding">
		<form id="form-config-site" method="POST" action="{{route('config.site.update', $data->id)}}" onsubmit="return false">
			<div class="columns">
				<div class="six-columns">
					<fieldset class="fieldset">
						@method("PUT")
						@csrf
					    <legend class="legend">Padrão do Site</legend>
						<p class="button-height inline-medium-label">
							<label for="header" class="label">Design Topo</label>
							<select name="header" class="select check-list">
								<option value="1" {{{ $data->header == 1 ? 'selected="selected"' : '' }}}>Padrão</option>
							</select>
						</p>
						<p class="button-height inline-medium-label">
							<label for="menu" class="label">Design Menu</label>
							<select name="menu" class="select check-list">
								<option value="1" {{{ $data->menu == 1 ? 'selected="selected"' : '' }}}>Padrão</option>
							</select>
						</p>
						<p class="button-height inline-medium-label">
							<label for="page_home" class="label">Página Home</label>
							<select name="page_home" class="select check-list">
								<option value="1" {{{ $data->page_home == 1 ? 'selected="selected"' : '' }}}>Padrão</option>
							</select>
						</p>
						<p class="button-height inline-medium-label">
							<label for="page_products" class="label">Página Produtos</label>
							<select name="page_products" class="select check-list">
								<option value="1" {{{ $data->page_products == 1 ? 'selected="selected"' : '' }}}>Padrão</option>
							</select>
						</p>
						<p class="button-height inline-medium-label">
							<label for="page_sections" class="label">Página Seções</label>
							<select name="page_sections" class="select check-list">
								<option value="1" {{{ $data->page_sections == 1 ? 'selected="selected"' : '' }}}>Padrão</option>
							</select>
						</p>
						<p class="button-height inline-medium-label">
							<label for="page_categories" class="label">Página Categorias</label>
							<select name="page_categories" class="select check-list">
								<option value="1" {{{ $data->page_categories == 1 ? 'selected="selected"' : '' }}}>Padrão</option>
							</select>
						</p>
						<p class="button-height inline-medium-label">
							<label for="page_brands" class="label">Página Marcas</label>
							<select name="page_brands" class="select check-list">
								<option value="1" {{{ $data->page_brands == 1 ? 'selected="selected"' : '' }}}>Padrão</option>
							</select>
						</p>
						<p class="button-height inline-medium-label">
							<label for="limit_products" class="label">Produtos por Página</label>
							<select name="limit_products" class="select check-list">
								<option value="10" {{{ $data->limit_products == 10 ? 'selected="selected"' : '' }}}>10</option>
								<option value="20" {{{ $data->limit_products == 20 ? 'selected="selected"' : '' }}}>20</option>
								<option value="30" {{{ $data->limit_products == 30 ? 'selected="selected"' : '' }}}>30</option>
								<option value="40" {{{ $data->limit_products == 40 ? 'selected="selected"' : '' }}}>40</option>
								<option value="50" {{{ $data->limit_products == 50 ? 'selected="selected"' : '' }}}>50</option>
							</select>
						</p>
						<p class="button-height inline-medium-label">
							<label for="list" class="label">Listar por:</label>
							<select name="list" class="select check-list">
								<option value="1" {{{ $data->list == 1 ? 'selected="selected"' : '' }}}>Produtos</option>
								<option value="2" {{{ $data->list == 2 ? 'selected="selected"' : '' }}}>Cores</option>
							</select>
						</p>

						<p class="button-height inline-medium-label">
							<label for="order_products" class="label">Ordem dos Produtos</label>
							<select name="order_products" class="select check-list">
								<option value="asc" {{{ $data->order_products == 'asc' ? 'selected="selected"' : '' }}}>Crescente</option>
								<option value="desc" {{{ $data->order_products == 'desc' ? 'selected="selected"' : '' }}}>Decrescente</option>
								<option value="random" {{{ $data->order_products == 'random' ? 'selected="selected"' : '' }}}>Aleatória</option>
							</select>
						</p>

						<p class="button-height inline-medium-label">
							<label for="order" class="label">Registrar Ordem</label>
							<select name="order" class="select check-list">
								<option value="wishlist" {{{ $data->order == 'wishlist' ? 'selected="selected"' : '' }}}>Lista de Desejo</option>
								<option value="cart" {{{ $data->order == 'cart' ? 'selected="selected"' : '' }}}>Carrinho</option>
							</select>
						</p>

						<p class="button-height inline-medium-label">
							<label for="detail_products" class="label">Detalhes do produto</label>
							<span class="button-group">
								<label for="detail_products-1" class="button green-active">
									<input type="radio" name="detail_products" id="detail_products-1" value="1" {{{ $data->detail_products == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="detail_products-0" class="button red-active" >
									<input type="radio" name="detail_products" id="detail_products-0" value="0" {{{ $data->detail_products == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="image_colors" class="label">Visualizar Cores</label>
							<span class="button-group">
								<label for="image_colors-1" class="button green-active">
									<input type="radio" name="image_colors" id="image_colors-1" value="1" {{{ $data->image_colors == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="image_colors-0" class="button red-active" >
									<input type="radio" name="image_colors" id="image_colors-0" value="0" {{{ $data->image_colors == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="image_positions" class="label">Visualizar Posições</label>
							<span class="button-group">
								<label for="image_positions-1" class="button green-active">
									<input type="radio" name="image_positions" id="image_positions-1" value="1" {{{ $data->image_positions == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="image_positions-0" class="button red-active" >
									<input type="radio" name="image_positions" id="image_positions-0" value="0" {{{ $data->image_positions == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="change_images" class="label">Mudar de Imagem</label>
							<span class="button-group">
								<label for="change_images-1" class="button green-active">
									<input type="radio" name="change_images" id="change_images-1" value="1" {{{ $data->change_images == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="change_images-0" class="button red-active" >
									<input type="radio" name="change_images" id="change_images-0" value="0" {{{ $data->change_images == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>					
						<p class="button-height inline-medium-label">
							<label for="tabs_products" class="label">Tabs do Produto</label>
							<span class="button-group">
								<label for="tabs_products-1" class="button green-active">
									<input type="radio" name="tabs_products" id="tabs_products-1" value="1" {{{ $data->tabs_products == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="tabs_products-0" class="button red-active" >
									<input type="radio" name="tabs_products" id="tabs_products-0" value="0" {{{ $data->tabs_products == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="long_description" class="label">Descrição Longa</label>
							<span class="button-group">
								<label for="long_description-1" class="button green-active">
									<input type="radio" name="long_description" id="long_description-1" value="1" {{{ $data->long_description == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="long_description-0" class="button red-active" >
									<input type="radio" name="long_description" id="long_description-0" value="0" {{{ $data->long_description == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="comments_products" class="label">Comentários</label>
							<span class="button-group">
								<label for="comments_products-1" class="button green-active">
									<input type="radio" name="comments_products" id="comments_products-1" value="1" {{{ $data->comments_products == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="comments_products-0" class="button red-active" >
									<input type="radio" name="comments_products" id="comments_products-0" value="0" {{{ $data->comments_products == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="tags_products" class="label">Tags</label>
							<span class="button-group">
								<label for="tags_products-1" class="button green-active">
									<input type="radio" name="tags_products" id="tags_products-1" value="1" {{{ $data->tags_products == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="tags_products-0" class="button red-active" >
									<input type="radio" name="tags_products" id="tags_products-0" value="0" {{{ $data->tags_products == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="related_products" class="label">Produtos Relacionados</label>
							<span class="button-group">
								<label for="related_products-1" class="button green-active">
									<input type="radio" name="related_products" id="related_products-1" value="1" {{{ $data->related_products == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="related_products-0" class="button red-active" >
									<input type="radio" name="related_products" id="related_products-0" value="0" {{{ $data->related_products == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="sidebar_products" class="label">Barra Lateral</label>
							<span class="button-group">
								<label for="sidebar_products-1" class="button green-active">
									<input type="radio" name="sidebar_products" id="sidebar_products-1" value="1" {{{ $data->sidebar_products == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="sidebar_products-0" class="button red-active" >
									<input type="radio" name="sidebar_products" id="sidebar_products-0" value="0" {{{ $data->sidebar_products == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="breadcrumbs" class="label">Cabeçalho</label>
							<span class="button-group">
								<label for="breadcrumbs-1" class="button green-active">
									<input type="radio" name="breadcrumbs" id="breadcrumbs-1" value="1" {{{ $data->breadcrumbs == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="breadcrumbs-0" class="button red-active" >
									<input type="radio" name="breadcrumbs" id="breadcrumbs-0" value="0" {{{ $data->breadcrumbs == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="countdown" class="label">Cronômetro (Ofertas)</label>
							<span class="button-group">
								<label for="countdown-1" class="button green-active">
									<input type="radio" name="countdown" id="countdown-1" value="1" {{{ $data->countdown == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="countdown-0" class="button red-active" >
									<input type="radio" name="countdown" id="countdown-0" value="0" {{{ $data->countdown == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>
						<p class="button-height inline-medium-label">
							<label for="social_share" class="label">Compartilhar</label>
							<span class="button-group">
								<label for="social_share-1" class="button green-active">
									<input type="radio" name="social_share" id="social_share-1" value="1" {{{ $data->social_share == 1 ? 'checked' : '' }}}>
									Sim
								</label>
								<label for="social_share-0" class="button red-active" >
									<input type="radio" name="social_share" id="social_share-0" value="0" {{{ $data->social_share == 0 ? 'checked' : '' }}}>
									Não
								</label>
							</span>
						</p>


					</fieldset>

				</div>
				<div class="six-columns">
					<h4 class="green underline">Observações</h4>
					<ol>
						<li><b>Design Topo:</b> Define qual deseign será o topo do site.</li>
						<li><b>Menu:</b> Define qual design do menu será utilizado no site.</li>
						<li><b>Página Home:</b> Define o design da página home.</li>
						<li><b>Página Produtos:</b> Define o design da página produtos.</li>
						<li><b>Página Seções:</b> Define design o da página seções.</li>
						<li><b>Página Categorias:</b> Define o design da página categorias.</li>
						<li><b>Página Marcas:</b> Define o design da página marcas.</li>
						<li><b>Produtos por Página:</b> Número de produtos a serem exibidos por página.</li>
						<li><b>Ordem dos Produtos:</b> Define a ordem que os produtos serão exibidos.<br>
							- Crescente: Exibe o registro dos mais antigos para os mais novos.<br>
							- Decrescente: Exibe o registro dos mais novos para os mais antigos.
							- Aleatória: Exibe os registros aleatoriamente.
						</li>
						<li><b>Registrar Ordem:</b> Define o modulo que os pedidos serão registrados.<br>
							- Adiciona os produtos na Lista de Desejo.<br>
							- Adiciona os produtos no Carrinho de Compras.
						</li>
						<li><b>Detalhes do produto:</b> Exibir detalhes dos produtos.</li>
						<li><b>Visualizar Cores:</b> Permite a visualização das cores dos produtos.</li>
						<li><b>Visualizar Posições:</b> Permite a visualização as posições das cores dos produtos.</li>
						<li><b>Mudar de Imagem:</b> Altera a imagem ao passar o mouse sobre a imagem.</li>

						<li><b>Tabs do Produto:</b> Permite exibir os modulos:<br>
							- Comentários: Exibe o formulário para comentar sobre o produto.<br>
							- Descrição Longa: Exibe a descrição do produto.<br>
							- Tags: Exibe as tags do produto.
						</li>
						<li><b>Descrição Longa:</b> Exibe a descrição do produto.</li>
						<li><b>Comentários:</b> Exibe o formulário para comentar sobre o produto.<br>
							- O comentário sera filtrado pelo administrador antes de ser bublicado.
						</li>
						<li><b>Tags:</b> Exibe as tags do produto.</li>
						<li><b>Produtos Relacionados:</b> Mostra ao visitante alguns produtos relacionados ao produto visitado.</li>
						<li><b>Barra Lateral:</b> Mostra uma barra lateral com produtos ou conteudo em destaque.</li>
						<li><b>Cabeçalho:</b> Define se será visualizado o cabeçalho.</li>
						<li><b>Cronômetro (Ofertas):</b> Ativa uma contagem regressiva da data atual para a data final do produto em ogerta. </li>
						<li><b>Compartilhar:</b> Adiciona os botões para o compartilhamento de páginas nas redes sociais.</li>
					</ol>
					@can('config-site-update')
						<p class="button-height inline-label">
							<button onclick="postFormJson($(this.form).attr('id'));" class="button icon-publish blue-gradient"> Salvar</button>
						</p>
					@endcan
				</div>
			</div>
		</form>
	</div>
</div>