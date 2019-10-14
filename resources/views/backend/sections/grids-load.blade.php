<p class="message icon-info-round white-gradient">
    Para adicionar uma grade clique no tipo, botão (+) para adicionar e slavar.
</p>
<form id="form-section-grids" method="POST" action="{{route('grids-section.store', $id)}}" onsubmit="return false">
    <input type="hidden" name="section_id" value="{{$id}}">
    @csrf
    <p class="button-height inline-small-label">
        <label for="input" class="label">Tipo:</label>
        <span class="button-group">
                    <label for="type-1" onclick="typeGrideSection('unit')" class="button blue-gradient green-active">
                        <input type="radio" name="type" id="type-1" value="unit">Unidade
                    </label>
                    <label for="type-2" onclick="typeGrideSection('kit')" class="button blue-gradient  green-active">
                        <input type="radio" name="type" id="type-2" value="kit">Embalagem
                    </label>
                    <label for="type-3" onclick="typeGrideSection('kit')" class="button blue-gradient green-active">
                        <input type="radio" name="type" id="type-3" value="kit">Caixa
                    </label>
                </span>
    </p>

    <p id="grid-name" class="button-height inline-small-label" style="display: none">
        <label for="name" class="label"> Nome: <span class="red">*</span></label>
        <input type="text" name="name" class="input" value="">
    </p>

    <div id="grid-unit" style="display: none">
        <p class="button-height inline-small-label">
            <label for="name" class="label"> Grade: <span class="red">*</span></label>
            <span class="puls_grid input margin-right">
                        <input type="text" name="label[]" value="" size="4" class="input-unstyled">
                        <button onclick="removeGridSection(this,'.puls_grid')" class="remove-unit button red-gradient icon-minus" title="Remover"></button>
                    </span>
            <span id="plus-unit"></span>

            <button onclick="plusUndSection()" class="button blue-gradient icon-plus" title="Adicionar"></button>
            @can('section-grids-create')
                <button id="btn-modal" onclick="formGridSection('{{$id}}','create', 'section-grids', '{{route('section-grids-load', $id)}}', 'Aguarde', 'Salvar')" class="button blue-gradient">
                    <span class="icon-tick"></span> Salvar
                </button>
            @endcan
        </p>
    </div>

    <div id="grid-kit" style="display: none">
        <p class="puls_grid button-height inline-small-label">
                    <span class="input">
                        <input type="text" name="qty[]" class="amount input-unstyled input-sep" placeholder="Qtd" value=""  maxlength="3" style="width: 30px;">
                        <input type="text" name="des[]" class="input-unstyled" placeholder="Descrição" value="" style="width: 80px;">
                        <button onclick="removeGridSection(this,'.puls_grid')" class="remove button red-gradient icon-minus" title="Remover"></button>
                    </span>
        </p>
        <div id="plus-kit"></div>
        <div class="large-margin-left margin-top">
            <button id="total-grids" class="button blue-gradient">0</button>
            <button onclick="plusKitSection()" class="button blue-gradient icon-plus" title="Adicionar"></button>
            @can('section-grids-create')
                <button id="btn-modal" onclick="formGridSection('{{$id}}','create', 'section-grids', '{{route('section-grids-load', $id)}}', 'Aguarde', 'Salvar')" class="button blue-gradient">
                    <span class="icon-tick"></span> Salvar
                </button>
            @endcan
        </div>

    </div>
</form>
<div id="grids" class="margin-top">
    @forelse($data as $val)
        <div id="grid_{{$val->id}}">
            <h3 class="thin underline margin-top">
                @if($val->type == 'kit')
                    <span class="icon-thumbs blue" title="Kit"></span>&nbsp;
                @endif
                @if($val->type == 'unit')
                    <span class="icon-stop green" title="Unidade"></span>&nbsp;
                @endif
                {{$val->name}}
                <span class="button-group compact">
                    @can('section-grids-delete')
                        <button id="btn-delete" onclick="deleteGridSection('{{ $val->id }}', '{{ $val->name }}', '{{route('grids-section.destroy', ['id' => $id, 'grid' => $val->id])}}', '{{ csrf_token() }}');" class="button icon-trash with-tooltip red-gradient" title="Excluir Grade"></button>
                    @endcan
                </span>
            </h3>
            @php $grids = explode(",", $val->label);@endphp
            @foreach($grids as $grid)
                <button class="button silver-gradient glossy">{{$grid}}</button>
            @endforeach
        </div>
    @empty
        <div><h3 class="thin underline">Não existe nenhuma grade cadastrada.</h3></div>
    @endforelse
</div>

