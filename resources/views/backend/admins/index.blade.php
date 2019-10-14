<div class="block-title">
    <h3><span class="icon-users"> </span><strong> Usuários do Sistema </strong></h3>
    <div class="button-group absolute-right">
        @can('model-admins-excluded')
            <a href="admin/excluded" class="button icon-users margin-left red-gradient glossy ">Exluidos</a>
        @endcan

        @can('model-admins-create')
            <a href="javascript:void(0)" onclick="abreModal('Adicionar Usuário', '{{route('admins.create')}}', 'admins', 2, 'true', 400, 470);" class="button margin-right with-tooltip" data-tooltip-options='{"classes":["anthracite-gradient"],"position":"bottom"}' title="Adicionar Usuários">Adicionar       <span class="button-icon right-side"><span class="icon-plus-round"></span></span></a>
        @endcan

    </div>
</div>
<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confAdmin->table_color.'.css')}}">

<table class="table responsive-table" id="admins">
    <thead>
    <tr>
        <th width="15%">Nome</th>
        <th width="15%" class="align-center hide-on-mobile">Nível</th>
        <th width="15%" class="align-center hide-on-mobile">Status</th>
        <th width="15%" class="align-center hide-on-mobile-portrait">Telefone</th>
        <th width="2%"></th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="5"></td>
    </tr>
    </tfoot>
</table>
<script src="{{mix('backend/scripts/admins/admins.min.js')}}"></script>
<script>
    var tableAdmin = {!! json_encode([
        "id" => 'admins',
        "url_admins" => route('admins.data'),
        "url_excluded" => route('admins.excluded.data'),
        "txtConfirm" => "Você confirma a exclusão",
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtSave" => "Salvar",
        "txtUpdate" => "Alterar",
        "token" => csrf_token(),
        "color" => $confAdmin->table_color,
        "colorSel" => $confAdmin->table_color_sel." glossy",
        "openDetails" => $confAdmin->table_open_details,
        "limit" => $confAdmin->table_limit,
        "tableStyled" => false
    ]) !!};
</script>

<script id="painel-admins" type="text/x-handlebars-template">
    <div id="painel_@{{{id}}}" class="content-panel margin-bottom">
        <div class="panel-navigation silver-gradient">
            <div class="panel-control">

            </div>
            <div class="panel-load-target scrollable" style="height:490px">
                <div class="navigable">
                    <ul class="files-list mini open-on-panel-content">
                        @can('model-admins-view')
                            <li>
                                <a href="admin/@{{{id}}}/profile" class="file-link">
                                    <span class="icon folder-pen"></span>
                                    Perfil do Usuário
                                </a>
                            </li>
                        @endcan
                        @can('model-admins-create')
                            <li>
                                <a href="admin/@{{{id}}}/photo-admin" class="file-link">
                                    <span class="icon file-image"></span>
                                    Foto do Usuário
                                </a>
                            </li>
                        @endcan
                        @can('model-admins-access')
                            <li>
                                <a href="admin/@{{{id}}}/access" class="file-link">
                                    <span class="icon folder-docs"></span>
                                    Acessos do Usuário
                                </a>
                            </li>
                        @endcan
                        @can('model-admins-permissions-view')
                            <li>
                                <a href="admin/@{{{id}}}/A/modules" class="file-link">
                                    <span class="icon folder-program"></span>
                                    Permissões de Acessos
                                </a>
                            </li>
                        @endcan
                        @can('model-admins-permissions-view')
                            <li>
                                <a href="admin/@{{{id}}}/C/modules" class="file-link">
                                    <span class="icon folder-program"></span>
                                    Permissões de Configurações
                                </a>
                            </li>
                        @endcan

                        @can('model-admins-historic')
                            <li>
                                <a href="admins/@{{{ id }}}/historic" class="file-link">
                                    <span class="icon folder-docs"></span>
                                    Histórico dos Pedidos
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
                                @can('model-admins-delete')
                                    <button id="btn-excluir" onclick="deleteAdmin('admins/@{{{id}}}', '@{{{name}}}');" class="button icon-trash with-tooltip red-gradient" title="Excluir Usuário">Excluir
                                    </button>
                                @endcan
                                @can('model-admins-update')
                                    <button id="btn-editar" onclick="abreModal('Alterar Usuário: @{{{name}}}', 'admins/@{{{id}}}/edit', 'dados-admins', 2, 'true', 400, 500);" class="button blue-gradient icon-pencil with-tooltip" title="Alterar Usuário">Editar
                                    </button>
                                @endcan
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="panel-load-target scrollable with-padding" style="height:450px">
                <div class="block">
                    <div class="with-padding">
                        <div class="float-right"></div>
                        <h4 class="blue underline">Perfil do Usuário</h4>
                        <p>Nome: <strong> @{{{name}}} </strong></p>
                        <p>Email: <strong> @{{{email}}} </strong></p>
                        <p>Telefone: <strong> @{{{phone}}} </strong></p>
                        <p>Perfil: <strong> @{{{profile}}} </strong></p>
                        <p>Status: <strong> @{{{txt_status}}} </strong></p>
                        <p>Comissao: <strong> @{{{commission}}}  @{{{percent}}} %</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<script>
    $.fn.loadTableAdmins();
</script>

