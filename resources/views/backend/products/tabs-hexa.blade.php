<div class="standard-tabs margin-bottom" id="add-tabs">
	<ul class="tabs new-product">
		<li id="show-product" class="active"><a href="#tab-product">Dados do Produto</a></li>
		<li id="show-colors" class="disabled"><a href="#tab-colors">Imagens</a></li>
		@if($configProduct->positions == 1)
			<li id="show-positions" class="disabled"><a href="#tab-positions">Posições</a></li>
		@endif	
	</ul>
	<div class="tabs-content">

		<div id="tab-product" class="with-padding">
            <!-- Form: product create -->
            @include('backend.products.form-create')
		</div>

		<div id="tab-colors" class="with-padding">
				@include('backend.colors.layout_hexa-create')
		</div>
		
		@if($configProduct->positions == 1)
			<div id="tab-positions" class="with-padding">
	            <!-- Form: posições -->
	            @include('backend.positions.form-create')
			</div>
		@endif

	</div>
</div>