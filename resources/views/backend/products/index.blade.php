<div class="block-title">
    <h3><span class="icon-read"> </span><strong> {{$title}} {{$data->name}} / {{$data->section}}</strong></h3>
    <div class="button-group absolute-right">
        @can('product-create')
            <a href="javascript:void(0)" onclick="abreModal('{{$title_create}} {{$data->name}} / {{$data->section}}', '{{route('catalog.create', $data->id)}}', 'products', 2, 'true', 820, 780);" class="button margin-right with-tooltip" data-tooltip-options='{"classes":["anthracite-gradient"],"position":"bottom"}' title="{{$title_create}}">Adicionar
            <span class="button-icon right-side"><span class="icon-plus-round"></span></span></a>
        @endcan
    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css') }}">

<table class="table responsive-table" id="products">
    <thead>
        <tr>
            <th scope="col" width="8%" class="align-center">Foto</th>
            <th scope="col" width="18%" class="align-center">Visitas</th>
            <th scope="col" width="18%" class="align-center">Novo</th>
            <th scope="col" width="18%" class="align-center">Oferta</th>
            <th scope="col" width="9%" class="align-center">Status</th>
            <th scope="col" width="9%" class="align-center">Destaque</th>
            <th scope="col" width="9%" class="align-center">Tendência</th>
            <th scope="col" width="9%" class="align-center">Black Friday</th>
            <th width="2%"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="9"></td>
        </tr>
    </tfoot>
</table>

<script src="{{ mix('backend/scripts/products/products.min.js') }}"></script>
<script src="{{ mix('backend/scripts/products/colors.min.js') }}"></script>
<script src="{{ mix('backend/scripts/products/positions.min.js') }}"></script>
<script src="{{ mix('backend/scripts/products/grids.min.js') }}"></script>
<script src="{{ mix('backend/js/libs/formData/jquery.form.min.js') }}"></script>

<script>   
    var tableProduct = {!! json_encode([
        "id" => 'products',
        "url" => route('products.data', $data->id),
        "txtUpdateGrids" => 'Você confirma a alteração da grade para ',
        "txtUpdateGridsStock" => '<small class="tag red-bg">O Estoque será zerado</small><br> Você confirma a alteração da grade para ',
        "txtUpdateStock" => '<small class="tag red-bg">O Estoque será zerado</small><br> Você confirma?',
        "txtConfirm" => "Você confirma a exclusão do produto ",
        "txtCancel" => "A ação foi cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtNext" => "Proximo",
        "txtSave" => "Salvar",
        "txtUpdate" => "Alterar",
        "txtGrid" => "Grade",
        "txtEntry" => "Entrada",
        "txtLow" => "Saida",
        "txtKit" => "Caixa",
        "txtUnit" => "Unidade",
        "txtLoader" => "Aguarde",
        "txtYes" => "Sim",
        "txtNot" => "Não",
        "avtive_true" => "Ativo",
        "avtive_false" => "Inativo",
        "token" => csrf_token(),
        "color" => $confUser->table_color,
        "colorSel" => $confUser->table_color_sel." glossy",
        "openDetails" => $confUser->table_open_details,
        "limit" => $confUser->table_limit,
        "tableStyled" => false
    ]) !!};
</script>

<script id="painel-products" type="text/x-handlebars-template">
<div id="painel_@{{{id}}}" class="content-panel margin-bottom">
    <div class="panel-navigation silver-gradient">
        <div class="panel-control">
        </div>
        <div class="panel-load-target scrollable" style="height:490px">
            <div class="navigable">
                <ul class="files-list mini open-on-panel-content">
                    @can('product-view')
                        <li>
                            <a href="product/@{{{id}}}/details" class="file-link">
                                <span class="icon file-css"></span>
                                Detalhes do Produto
                            </a>
                        </li>
                    @endcan
                    @can('product-images-view')
                        <li>
                            <a href="colors/@{{{id}}}/colors-product" class="file-link">
                                <span class="icon folder-image"></span>
                                Editar Cores
                            </a>
                        </li>
                    @endcan
                    @if($configProduct->positions == 1)
                        @can('product-images-view')
                            <li>
                                <a href="position/@{{{id}}}/positions-product" class="file-link">
                                    <span class="icon folder-image"></span>
                                    Editar Posições
                                </a>
                            </li>
                        @endcan
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-content linen navigable">

        <div class="panel-control align-right">
            <div class="open-on-panel-content">
                @can('product-delete')
                    <button id="btn-excluir" onclick="deleteProduct('products/{{$data->slug}}/catalog/@{{{id}}}', '@{{{name}}}');" class="button icon-trash with-tooltip red-gradient" title="Excluir Categoria">Excluir
                    </button>
                @endcan
                @can('product-update')
                    <button id="btn-editar"  onclick="abreModal('Editar Produto {{$data->name}} / {{$data->section}}', 'products/{{$data->slug}}/catalog/@{{{id}}}/edit', 'products', 2, 'true', 800, 780);" class="button blue-gradient icon-pencil with-tooltip" title="Alterar Produto">Editar
                    </button>
                @endcan
            </div>   
        </div>

        <div id="info-product-@{{{id}}}"  class="panel-load-target scrollable with-padding" style="height:450px">
            <div class="block">
                <div class="with-padding">
                    <h4 class="blue underline">Perfil do Produto</h4>
                        <p>Nome: <strong> @{{{name}}} </strong></p>
                        <p>Descrição: <strong> @{{{description}}} </strong></p>
                        <p>Tags: <strong> @{{{tags}}} </strong></p>
                        @{{{cost}}}
                        @{{{sum_stock}}}
                        @{{{kit}}}
                        <p>Unidade Medida: <strong>  @{{{unit}}} @{{{measure}}} </strong></p>
                        @{{{prices}}}
                        @{{{freight}}}
                        @{{{video}}}
                </div>
            </div>
        </div>
    </div>
</div>
</script>

<script>
$.fn.loadTableProducts();
</script>

