<div class="block-title">
    <h3><span class="icon-mail"> </span><strong> {{$title}} </strong></h3>
    <div class="button-group absolute-right">
        @can('contact-update')
            <a href="contacts" class="button icon-mail margin-left blue-gradient glossy ">Contatos</a>
        @endcan
    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="spams">
    <thead>
        <tr>
            <th width="18%">Data</th>
            <th width="20%" class="align-center">Nome</th>
            <th width="20%" class="align-center">Email</th>
            <th class="hide-on-mobile">Mensagem</th>
            <th width="2%"></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="5"></td>
        </tr>
    </tfoot>
</table>
<script src="{{mix('backend/scripts/contacts/spams.min.js')}}"></script>
<script>
    var tableSpam = {!! json_encode([
        "id" => 'spams',
        "url" => route('spams.data'),
        "txtConfirm" => '<small class="tag red-bg">Os produtos desta marca serão excluidos</small><br>Você confirma a exclusão',
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtSave" => "Salvar",
        "txtUpdate" => "Alterar",
        "token" => csrf_token(),
        "color" => $confUser->table_color,
        "colorSel" => $confUser->table_color_sel." glossy",
        "openDetails" => $confUser->table_open_details,
        "limit" => $confUser->table_limit,
        "tableStyled" => false
    ]) !!};
</script>

<script id="painel-spams" type="text/x-handlebars-template">
<div id="painel_@{{{id}}}" class="content-panel margin-bottom">
    <div class="panel-navigation silver-gradient">
        <div class="panel-control"></div>
        <div class="panel-load-target scrollable" style="height:490px">
            <div class="navigable">
                <ul class="files-list mini open-on-panel-content">
                    @can('contact-send')
                        <li>
                            <a href="spam/message/@{{{id}}}" class="file-link">
                                <span class="icon file-rtf"></span>
                                Mensagem
                            </a>
                        </li>
                    @endcan
                    @can('contact-view')
                        <li>
                            <a href="spam/@{{{id}}}/details" class="file-link">
                                <span class="icon file-chm"></span>
                                Perfil do Contato
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
                @can('contact-update')
                    <span class="button-group children-tooltip">
                        <button onclick="deleteSpam('@{{{id}}}')" class="button icon-trash red-gradient" title="Excluir">Exculir</button>
                        <button onclick="changeSpam('@{{{id}}}')" class="button icon-undo blue-gradient" title="Não é Spam">Não é Spam</button>
                    </span>
                @endcan
            </div>   
        </div>

        <div class="panel-load-target scrollable with-padding" style="height:450px">
            <div class="large-box-shadow white-gradient with-border">
                <div class="with-padding">
                    <h4 class="blue underline">Perfil do Contato</h4>
                    <p>Nome: <strong> @{{{name}}}</strong></p>
                    <p>Email: <strong> @{{{email}}} </strong></p>
                    <p>Telefone: <strong> @{{{phone}}} </strong></p>
                    <p>Celular: <strong> @{{{cell}}} </strong></p>
                    <p>Cidade: <strong> @{{{city}}} </strong></p>
                    <p>Estado: <strong> @{{{state}}} </strong></p>
                    <p>CEP: <strong> @{{{zip_code}}} </strong></p>
                    <p>IP: <strong> @{{{ip}}} </strong></p>
                </div>
            </div>
        </div>




    </div>
</div>
</script>

<script>
$.fn.loadTableSpams();
</script>

