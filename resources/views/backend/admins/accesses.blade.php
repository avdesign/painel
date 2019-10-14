<div class="block">
    <div class="with-padding">
        @if(count($files) >= 2)
            @can('model-users-access-delete')
                <div class="float-right">
                    <button id="del-all-{{$data->id}}" onclick="adminAccessTxt('delete-all', '{{$id}}', '{{$data->name}}');" class="button icon-trash red-gradient compact" title="Excluir Todos">Excluir Todos</button>
                </div>
            @endcan
        @endif
        <h4 class="blue underline">Iformações dos Acessos</h4>
        <div id="return_{{$id}}"></div>
        <div id="info_{{$id}}">
            <ul class="bullet-list">
                @foreach($access as $acc)
                <li>Total de Acessos : <strong> {{ $acc->qty_visits }} </strong></li>
                <li>Última Data: <strong> {{ $acc->updated_at }} </strong></li>
                <li>Última Página: <strong> #{{ $acc->last_url }} </strong></li>
                <li>Último IP: <strong> {{ $acc->last_ip }} </strong></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<ul id="files_{{$id}}" class="files-icons on-dark">

    @forelse($files as $file)
        <li id="{{ $file['date'] }}_{{$id}}">
            <span class="icon file-ini"></span>
            <div class="controls">
            <span class="button-group compact children-tooltip">
                @can('model-admins-access-delete')
                    <button onclick="adminAccessTxt('delete', '{{$id}}', '{{$data->name}}', '{{$file['path']}}', '{{$file['date']}}');" class="button icon-trash red-gradient" title="Excluir"></button>
                @endcan
                @can('model-admins-access')
                    <button onclick="adminAccessTxt('open', '{{$id}}', '{{$data->name}}', '{{$file['path']}}', '{{$file['date']}}');" class="button icon-gear blue-gradient" title="Ver Acessos"></button>
                @endcan
            </span>
            </div>
            <b>{{ $file['date'] }}</b>
        </li>
    @empty

    @endforelse
</ul>

<script>
    $(".block").click(function (){return false;});
    var filesAccess = {!! json_encode([
        "url" => route('admin.access.actions', $id),
        "txtConfirmAll" => "Você confirma a exclusão de todos os arquivos de ",
        "txtConfirm" => "Você confirma a exclusão do arquivo:<br>",
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtAll" => "de todos",
        "txtError" => "Houve um erro no servidor!",
        "txtDelete" => "Excluir Todos",
        "txtLoader" => "Aguardando...",
        "token" => csrf_token()
    ]) !!};
</script>



