<div class="block-title">
    <h3><span class="icon-users red"> </span><strong class="red"> {{$title}} </strong></h3>
    <div class="button-group absolute-right">                        
       <a href="admins" class="button icon-users margin-left blue-gradient glossy"> Usuários Ativos</a>
    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confAdmin->table_color.'.css')}}">
<table class="table responsive-table" id="excluded">
    <thead>
        <tr>
            <th width="15%">Nome</th>
            <th width="15%" class="align-center hide-on-mobile">Perfil</th>
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

<script src="{{mix('backend/scripts/admins/admins-excluded.min.js')}}"></script>
<script>
    var tableAdminExcluded = {!! json_encode([
        "id" => 'excluded',
        "url_excluded" => route('admins.excluded.data'),
        "url_reactivate" => route('admins.reactivate'),
        "confirmReactivate" => "Deseja reativar o usuário: ",
        "cancelReactivate" => "A reativação de foi cancelada!",
        "errorServer" => "Houve um erro no servidor!",
        "txtReactivate" => "Reativar",
        "token" => csrf_token(),
        "color" => $confAdmin->table_color,
        "colorSel" => $confAdmin->table_color_sel." glossy",
        "openDetails" => $confAdmin->table_open_details,
        "limit" => $confAdmin->table_limit,
        "tableStyled" => false
    ]) !!};
</script>
<script id="painel-excluded" type="text/x-handlebars-template">
<div id="excluded_@{{{id}}}" class="content-panel margin-bottom">
    <div class="panel-navigation silver-gradient">
        <div class="panel-control">
            <button id="btn-reactivate" onclick="reactivateAdminExcluded('@{{{id}}}', '@{{{name}}}')" class="button blue-gradient with-tooltip" title="Reativar Usuário">
                <span class="icon-user"></span> Reativar Usuário
            </button>        
        </div>
        <div class="panel-load-target scrollable" style="height:490px">
            <div class="navigable">
                <ul class="files-list mini open-on-panel-content">

                    @can('model-admins-view')
                        <li>
                            <a href="admin/excluded/@{{{id}}}/profile" class="file-link">
                                <span class="icon folder-pen"></span>
                                Perfil do Usuário
                            </a>
                        </li>
                    @endcan
                    @can('model-admins-create')
                        <li>
                            <a href="admin/excluded/@{{{id}}}/photo-admin" class="file-link">
                                <span class="icon file-image"></span>
                                Foto do Usuário
                            </a>
                        </li>
                    @endcan
                    @can('model-admins-access')
                        <li>
                            <a href="admin/excluded/@{{{id}}}/access" class="file-link">
                                <span class="icon folder-docs"></span>
                                Acessos do Usuário
                            </a>
                        </li>
                    @endcan

                    @can('model-admins-historic')
                        <li>
                            <a href="admins/@{{{id}}}/historic" class="file-link">
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
        <div class="panel-load-target scrollable with-padding" style="height:450px">
            <div class="block">
                <div class="with-padding">
                    <div class="float-right"></div>
                    <h4 class="blue underline">Perfil do Usuário</h4>
                    <ul class="bullet-list">
                        <li>Nome: <strong> @{{{name}}} </strong></li>
                        <li>Email: <strong> @{{{email}}} </strong></li>
                        <li>Telefone: <strong> @{{{phone}}} </strong></li>
                        <li>Perfil: <strong> @{{{profile}}} </strong></li>
                        <li>Status: <strong> @{{{txt_status}}} </strong></li>
                        <li>Comissao: <strong> @{{{commission}}}  @{{{percent}}} %</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</script>
<script>
$.fn.loadAdminsExcluded();
</script>