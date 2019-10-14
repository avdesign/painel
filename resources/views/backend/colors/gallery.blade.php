<div id="data-images-{{$idpro}}">
	<div class="block-title silver-gradient">
		<h3>
			<i class="fa fa-cog" aria-hidden="true"></i>
			<strong> Editar Cores </strong>
		</h3>
		<div class="button-group absolute-right">
			<a href="javascript:void(0)"
				onclick="abreModal('Adicionar: Cor', '{{route('colors-product.create', $idpro)}}', 'form-colors', 2, 'true',800,780);"
				class="button icon-camera blue-gradient glossy">Adicionar Cores
			</a>
		</div>	
	</div>
	<div class="with-padding silver-gradient">
		<div align="center">
			<span id="loader_{{$idpro}}" class="loader big working" style="display:none"></span>
		</div>	
		<div id="load_form_colors_{{$idpro}}"></div>

		<h4 class="blue underline"><strong>{{$title_count}}</strong></h4>

		<ul id="gallery-colors-{{$idpro}}" class="gallery">
		    @forelse($colors->sortBy('ordem') as $color)
				<li id="img-colors-{{$color->id}}">
					<img src="{{url($path.$color->image)}}" class="framed">
					<div class="controls">
						@php
							($color->active == constLang('active_true') ? $col = 'green' : $col = 'red');
							($color->cover == 1 ? $title = constLang('cover') : $title = '');
							($color->cover == 1 ? $option = '{"classes":["red-gradient"],"position":"top"}' : $option = '');
						@endphp
						<span id="btns-{{$color->id}}" class="button-group compact children-tooltip" data-tooltip-options='{{$option}}'>
							<button onclick="statusColor('{{$color->id}}','{{route('status-color', ['idpro' => $idpro,'id' => $color->id])}}','{{$color->active}}','{{$color->capa}}','{{csrf_token()}}');" class="button icon-tick {{$col}}-gradient" title="Alterar status {{$title}}"></button>
							<button onclick="abreModal('Editar: Cor {{$color->color}}', '{{route('colors-product.edit', ['idpro' => $color->product_id,'id' => $color->id])}}', 'form-colors', 2, 'true',800,780);" class="button" title="Editar imagem {{$title}}">Editar</button>
							<button onclick="deleteColor('{{$color->id}}', '{{route('colors-product.destroy', ['idpro' => $color->product_id, 'id' => $color->id])}}');" class="button icon-trash red-gradient" title="Excluir imagem {{$title}}"></button>
						</span>
					</div>
				</li>
			@empty
			@endforelse
		</ul>
	</div>
</div>