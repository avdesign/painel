<div class="block-title">
    <h3><span class="icon-heart-empty icon-size2"> </span><strong> {{$title}} </strong></h3>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="wishlist">
    <thead>
        <tr>
            <th width="5%" class="align-center">Total</th>
            <th width="25%" class="align-center">Cliente</th>
            <th width="10%" class="align-center">Vendedor</th>
            <th width="2%"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="4"></td>
        </tr>
    </tfoot>
</table>
<script src="{{mix('backend/scripts/wishlist.min.js')}}"></script>
<script>
    var tableWishlist= {!! json_encode([
        "id" => 'wishlist',
        "url" => route('wishlist.data'),
        "txtConfirm" => '<small class="tag red-bg"> O Produto será excluido </small><br>Você confirma a exclusão',
        "txtConfirmAll" => '<small class="tag red-bg"> TODOS OS PRODUTOS DESTA LISTA SERÃO EXCLUIDOS </small><br>Você confirma a exclusão',
        "txtConfirmOrder" => 'Você deseja criar uma ordem desta lista?',
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
</script>

<script id="painel-wishlist" type="text/x-handlebars-template">
<div id="painel_@{{{id}}}" class="content-panel margin-bottom">
    <div class="panel-navigation silver-gradient">
        <div class="panel-control"></div>
        <div class="panel-load-target scrollable" style="height:400px">
            <div class="navigable">
                <ul class="files-list mini open-on-panel-content">
                    @can('brand-view')
                        <li>
                            <a href="wishlist/@{{{user_id}}}/profile" class="file-link">
                                <span class="icon file-css"></span>
                                Perfil do Cliente
                            </a>
                        </li>
                    @endcan
                    @can('brand-view')
                        <li>
                            <a href="wishlist/@{{{user_id}}}/lists" class="file-link">
                                <span class="icon folder-docs"></span>
                                Lista de Desejos
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
                            <button onclick="abreModal('Editar Atendente', 'wishlist/admin/@{{{user_id}}}/edit', 'edit-admim', 2, 'true', 400, 300);" class="button icon-user blue-gradient">Atendente</button>
                            <button onclick="deleteWishlistAll('wishlist/delete/@{{{user_id}}}/all', '@{{{user_id}}}')" class="button icon-trash with-tooltip red-gradient" title="Excluir Lista"></button>
                        </div>
                    </li>
                </ul>
            </div>   
        </div>

        <div class="panel-load-target scrollable with-padding" style="height:400px">
            <div class="block">
                <div class="with-padding">
                    <h4 class="blue underline">@{{{profile}}}</h4>
                    <ul class="bullet-list">
                        <li>Código: <strong> @{{{user_id}}} </strong></li>
                        @{{{name_html}}}
                        @{{{document_html}}}
                        <li>Email: <strong> @{{{email}}} </strong></li>
                        <li>Telefone : <strong> @{{{phone}}} </strong></li>
                        <li>Celular: <strong> @{{{cell}}} </strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</script>

<script>
$.fn.loadTableWishlist();
</script>