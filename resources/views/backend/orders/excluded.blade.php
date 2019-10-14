<div class="block-title">
    <h3><span class="icon icon-clipboard"> </span><strong> {{$title}} </strong></h3>
    <div class="button-group absolute-right">
        <a href="orders" class="button icon-clipboard margin-left blue-gradient glossy ">Pedidos</a>

    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="orders-excludeds">
    <thead>
    <tr>
        <th width="5%" class="align-center">Código</th>
        <th width="5%" class="align-center">UF</th>
        <th class="align-center">Cliente</th>
        <th width="10%" class="align-center">Perfil</th>
        <th width="10%" class="align-center">Pagamento</th>
        <th width="10%" class="align-center">Valor</th>
        <th width="10%" class="align-center">Status</th>
        <th width="10%" class="align-center">Data</th>
        <th width="2%"></th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="9"></td>
    </tr>
    </tfoot>
</table>
<script src="{{mix('backend/scripts/orders/excludeds.min.js')}}"></script>
<script>
    var tableOrderExcluded = {!! json_encode([
        "id" => 'orders-excludeds',
        "url" => route('orders.excluded.data'),
        "txtConfirm" => '<small class="tag red-bg"> O pedido será excluido </small><br>Você confirma a exclusão',
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtSave" => "Salvar",
        "txtLoader" => "Aguarde",
        "txtUpdate" => "Alterar",
        "txtReactivate" => "Você confirma a reativação do pedido ",
        "txtCancelReactivate" => "A reativação foi fancelada!",
        "token" => csrf_token(),
        "color" => $confUser->table_color,
        "colorSel" => $confUser->table_color_sel." glossy",
        "openDetails" => $confUser->table_open_details,
        "limit" => $confUser->table_limit,
        "tableStyled" => false
    ]) !!};
</script>

<script id="painel-orders-excludeds" type="text/x-handlebars-template">
    <div id="painel_@{{{id}}}" class="content-panel margin-bottom">
        <div class="panel-navigation silver-gradient">
            <div class="panel-control">
                <div class="align-center">
                    <button class="button compact"><span class="button-icon blue-gradient glossy">@{{{notes}}}</span>Observação</button>
                </div>
            </div>
            <div class="panel-load-target scrollable" style="height:400px">
                <div class="navigable">
                    <ul class="files-list mini open-on-panel-content">
                        @can('order-view')
                            <li>
                                <a href="order/@{{{id}}}/details" class="file-link">
                                    <span class="icon file-css"></span>
                                    Detalhes do Pedido
                                </a>
                            </li>
                        @endcan
                        @can('order-view')
                            <li>
                                <a href="order/@{{{id}}}/list-items" class="file-link">
                                    <span class="icon folder-docs"></span>
                                    Produtos do Pedido
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-content linen navigable">

            <div class="panel-control align-right">
                <div class="open-on-panel-content">

                    <ul class="list">

                        <li>
                            <div class="button-group absolute-right compact">
                                <button onclick="reactivateOrder('@{{{id}}}','order/@{{{id}}}/reactivate')" class="button icon-clipboard with-tooltip blue-gradient" title="Reativar Pedido">
                                    Reativar Pedido
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="panel-load-target scrollable with-padding" style="height:400px">
                <div class="block">
                    <div class="with-padding">
                        <div class="columns">
                            <div class="six-columns">
                                @{{{profile_html}}}
                                @{{{name_html}}}
                                @{{{document_html}}}
                                <p>Email: <strong> @{{{email}}} </strong></p>
                                <p>WhatsApp: <strong> @{{{cell}}} </strong></p>
                                <p>Telefone: <strong> @{{{phone}}} </strong></p>
                                @{{{delivery}}}
                                <p>Endereço: <strong> @{{{address}}}, @{{{number}}}</strong></p>
                                <p>Complemento: <strong> @{{{complement}}}</strong></p>
                                <p>Bairro: <strong> @{{{district}}}</strong></p>
                                <p>Cidade: <strong> @{{{city}}}</strong></p>
                                <p>Estado: <strong> @{{{state2}}}</strong></p>
                                <p>CEP: <strong> @{{{zip_code}}}</strong></p>
                            </div>
                            <div class="six-columns">
                                <h4 class="blue underline">Pedido N&deg;:@{{{id}}}</h4>
                                <p>Status: <strong> @{{{status}}} </strong></p>
                                <p>Pagamento: <strong> @{{{payment}}} </strong></p>
                                <p>À Vista: <strong> @{{{price_cash}}} </strong></p>
                                <p>No Cartão: <strong> @{{{price_card}}} </strong></p>
                                <p>Desconto: <strong> @{{{discount}}} </strong></p>
                                <p>Taxa: <strong> @{{{tax}}} </strong></p>
                                <h4 class="blue underline">Dados do Frete</h4>
                                <p>Taxa: <strong> @{{{freight}}} </strong></p>
                                @{{{weight}}}
                                @{{{width}}}
                                @{{{height}}}
                                @{{{length}}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<script>
    $.fn.loadTableOrdersExcludeds();
</script>