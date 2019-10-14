<div class="block-title">
    <h3><span class="icon-users"> </span><strong> {{$title}} </strong></h3>
    <div class="button-group absolute-right">
        @can('account-delete')
            <a href="accounts/excluded" class="button icon-users margin-left red-gradient glossy ">Excluidos</a>
        @endcan

        @can('account-create')
            <a href="javascript:void(0)" onclick="abreModal('Adicionar Cliente', '{{route('accounts.create')}}', 'accounts', 2, 'true', 500, 800);" class="button margin-right with-tooltip" data-tooltip-options='{"classes":["anthracite-gradient"],"position":"bottom"}' title="Adicionar Usuários">Adicionar       <span class="button-icon right-side"><span class="icon-plus-round"></span></span></a>
        @endcan

    </div>
</div>
<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="accounts">
    <thead>
    <tr>
        <th width="15%">Código</th>
        <th width="15%" class="align-center hide-on-mobile">Perfil</th>
        <th class="align-center">Nome</th>
        <th width="5%" class="align-center hide-on-mobile">Visitas</th>
        <th width="20%" class="align-center hide-on-mobile-portrait">Vendedor</th>
        <th width="5%" class="align-center hide-on-mobile-portrait">status</th>
        <th width="2%"></th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="7"></td>
    </tr>
    </tfoot>
</table>
<script src="{{mix('backend/scripts/accounts/accounts.min.js')}}"></script>
<script>
    var tableAccount = {!! json_encode([
        "id" => 'accounts',
        "url_accounts" => route('accounts.data'),
        "txtConfirm" => "Você confirma a exclusão",
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtSave" => "Salvar",
        "txtUpdate" => "Alterar",
        "txtAtert" => "Para excluir este cliente é obrigatório adicionar uma observação.",
        "token" => csrf_token(),
        "color" => $confUser->table_color,
        "colorSel" => $confUser->table_color_sel." glossy",
        "openDetails" => $confUser->table_open_details,
        "limit" => $confUser->table_limit,
        "tableStyled" => false
    ]) !!};
</script>

<script id="painel-accounts" type="text/x-handlebars-template">
    <div id="painel_@{{{id}}}" class="content-panel margin-bottom">
        <div class="panel-navigation silver-gradient">
            <div class="panel-control">

            </div>
            <div class="panel-load-target scrollable" style="height:490px">
                <div class="navigable">
                    <ul class="files-list mini open-on-panel-content">
                        <li>
                            <a href="account/@{{{id}}}/profile" class="file-link">
                                <span class="icon folder-pen"></span>
                                Perfil do Cliente
                            </a>
                        </li>
                        <li>
                            <a href="account/@{{{id}}}/address" class="file-link">
                                <span class="icon folder-pen"></span>
                                Endereço de Entrega
                            </a>
                        </li>
                        <li>
                            <a href="account/@{{{id}}}/notes" class="file-link">
                                <span class="icon folder-pen"></span>
                                Observações
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
                                @can('account-delete')
                                    <button id="btn-excluir" onclick="deleteAccount('@{{{id}}}','accounts/@{{{id}}}', '@{{{first_name}}}');" class="button icon-trash with-tooltip red-gradient" title="Excluir Cliente">Excluir
                                    </button>
                                    <button id="btn-help" class="button icon-question with-tooltip" data-tooltip-options='{"classes":["black-gradient","glossy"]}' title="<strong>Para excluir este cliente</strong><br>É obrigatório adicionar uma observação."></button>

                                @endcan
                            </div>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="panel-load-target scrollable with-padding" style="height:450px">
                <div class="large-box-shadow white-gradient with-border">
                    <div class="with-padding">
                        <h4 class="blue underline">
                            @{{{profile_id}}}
                            <span class="button-group float-right compact">
                                @can('account-update')
                                    <button id="btn-editar" onclick="abreModal('Alterar Cliente: @{{{first_name}}}', 'accounts/@{{{id}}}/edit', 'dados-accounts', 2, 'true', 400, 500);" class="button blue-gradient icon-pencil with-tooltip" title="Alterar Cliente">
                                        Editar
                                    </button>
                                @endcan
                            </span>
                        </h4>
                        @{{{notes}}}
                        @{{{html_name}}}
                        @{{{html_document}}}
                        <p>Email: <strong> @{{{email}}} </strong></p>
                        <p>Telefone: <strong> @{{{phone}}} </strong></p>
                        <p>Celular: <strong> @{{{cell}}} </strong></p>
                        <p>Status: <strong> @{{{active}}} </strong></p>
                        <p>Vendedor: <strong> @{{{admin}}} </strong></p>
                        <p>Cliente: <strong> @{{{client}}} </strong></p>
                        <p>Data Nascimento: <strong> @{{{date}}} </strong></p>
                        <p>Total de Visitas: <strong> @{{{visits}}} </strong></p>
                        <p>Data Cadastro: <strong> @{{{created_at}}} </strong></p>
                        <p>Alterou Cadastro: <strong> @{{{updated_at}}} </strong></p>
                        <p>Ultimo Login: <strong> @{{{last_login}}} </strong></p>
                        <p>Data Logout: <strong> @{{{logout}}} </strong></p>
                        <p>IP: <strong> @{{{ip}}} </strong></p>
                        <input type="hidden" id="note_@{{{id}}}" value="@{{{count_notes}}}"></input>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<script>
    $.fn.loadTableAccounts();
</script>

