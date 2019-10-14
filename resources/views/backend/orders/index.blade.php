<div class="block-title">
    <h3><span class="icon icon-clipboard"> </span><strong> {{$title}} </strong></h3>
    <div class="button-group absolute-right">
        <a href="orders/excluded" class="button icon-clipboard margin-left red-gradient glossy ">Excluidos</a>
        @can('orders-create')
            <a href="javascript:void(0)" onclick="abreModal('{{$title_create}}', '{{route('orders.create')}}', 'accounts', 2, 'true', 400, 260);" class="button margin-right with-tooltip" data-tooltip-options='{"classes":["anthracite-gradient"],"position":"bottom"}' title="{{$title_create}}">Adicionar
                <span class="button-icon right-side"><span class="icon-plus-round"></span></span>
            </a>
        @endcan
    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="orders">
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

<script src="{{mix('backend/scripts/orders/orders.min.js')}}"></script>
<script src="{{mix('backend/scripts/orders/items.min.js')}}"></script>
<script src="{{mix('backend/scripts/orders/notes.min.js')}}"></script>
<script src="{{mix('backend/scripts/orders/shippings.min.js')}}"></script>

<script>
    var tableOrders = {!! json_encode([
        "id" => 'orders',
        "url" => route('orders.data'),
        "txtConfirm" => '<small class="tag red-bg"> O pedido será excluido </small><br>Você confirma a exclusão',
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtSave" => "Salvar",
        "txtLoader" => "Aguarde",
        "txtUpdate" => "Alterar",
        "token" => csrf_token(),
        "color" => $confUser->table_color,
        "colorSel" => $confUser->table_color_sel." glossy",
        "openDetails" => $confUser->table_open_details,
        "limit" => $confUser->table_limit,
        "tableStyled" => false
    ]) !!};
    var tableOrderProduct = {!! json_encode([
        "txtRemove" => '<small class="tag red-bg"> O produto será excluido </small><br>Você confirma a exclusão',
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtSave" => "Salvar",
        "txtLoader" => "Aguarde",
        "txtUpdate" => "Alterar",
        "token" => csrf_token()
    ]) !!};

</script>

<script id="painel-orders" type="text/x-handlebars-template">
<div id="painel_@{{{id}}}" class="content-panel margin-bottom">
    <div class="panel-navigation silver-gradient">
        <div class="panel-control">
            <div class="button-group align-center compact">
                <button class="button compact"><span class="button-icon blue-gradient glossy">@{{{notes}}}</span>Observação</button>
                <button onclick="abreModal('Editar Atendente', 'wishlist/admin/@{{{user_id}}}/edit', 'edit-admim', 2, 'true', 400, 300);"
                        class="button icon-user blue-gradient">Atendente
                </button>
            </div>

        </div>
        <div class="panel-load-target scrollable" style="height:400px">
            <div class="navigable">
                <ul class="files-list mini open-on-panel-content">
                    @can('orders-view')
                        <li>
                            <a href="order/@{{{id}}}/details" class="file-link">
                                <span class="icon file-css"></span>
                                Detalhes do Pedido
                            </a>
                        </li>
                    @endcan
                    @can('orders-view')
                        <li>
                            <a href="order/@{{{id}}}/order-items" class="file-link">
                                <span class="icon folder-docs"></span>
                                Produtos do Pedido
                            </a>
                        </li>
                    @endcan
                    @can('orders-view')
                        <li>
                            <a href="order/@{{{id}}}/order-shippings" class="file-link">
                                <span class="icon folder-docs"></span>
                                Método de Envio
                            </a>
                        </li>
                    @endcan
                    @can('orders-view')
                        <li>
                            <a href="order/@{{{id}}}/order-notes" class="file-link">
                                <span class="icon folder-docs"></span>
                                Observações
                            </a>
                        </li>
                    @endcan

                        <li>
                            <a href="gateway/@{{{str_company}}}/@{{{id}}}" class="file-link">
                                <span class="icon file-dll"></span>
                                Transações PagSeguro
                            </a>
                        </li>


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
                            <button onclick="deleteOrder('orders/@{{{id}}}', '@{{{id}}}')" class="button icon-trash with-tooltip red-gradient" title="Excluir Lista"></button>
                            <button onclick="abreModal('{{$title_edit}}', 'orders/@{{{id}}}/edit', 'edit-order', 2, 'true', 400, 400);" class="button icon-pencil blue-gradient with-tooltip">Editar</button>
                            <button onclick="downloadPdf('order/@{{{id}}}/download')"  class="button icon-down-fat with-tooltip green-gradient"></button>
                            <button onclick="printerPdf('order/@{{{id}}}/printer')"  class="button icon-printer with-tooltip anthracite-gradient">{{$title_printer}}</button>
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
                            <p>IP: <strong> @{{{ip}}}</strong></p>
                        </div>
                        <div class="six-columns">
                            <h4 class="blue underline">Pedido: @{{{reference}}}</h4>
                            <p>Status: <strong> @{{{status_label}}} </strong></p>
                            <p>Gatteway: <strong> @{{{company}}} </strong></p>
                            <p>Pagamento: <strong> @{{{payment}}} </strong></p>
                            @{{{value}}}
                            <p>Desconto: <strong> @{{{discount}}} </strong></p>
                            <p>Taxa: <strong> @{{{tax}}} </strong></p>
                            <h4 class="blue underline">Dados do Frete</h4>
                            <p>Valor: <strong> @{{{freight}}} </strong></p>
                            @{{{shipping}}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</script>

<script>
$.fn.loadTableOrders();
</script>