@forelse($notes as $data)
    <div id="note-{{$data->id}}" class="mid-margin-top">
        <br>
        <h4 class="anthracite underline"> {{$data->label}}
            <span class="button-group float-right compact">
                @can('account-delete')
                    <button id="btn-delete" onclick="deleteNote('{{$data->id}}','{{route('notes.destroy', ['id' => $data->id, 'user_id' => $data->user_id])}}')" class="button red-gradient icon-trash with-tooltip" title="Exluir Observação"></button>
                @endcan
                @can('account-update')
                    <button id="btn-edit" onclick="abreModal('Alterar Observação', '{{route('notes.edit', ['id' => $data->id, 'user_id' => $data->user_id])}}', 'dados-clientes', 2, 'true', 400, 300);" class="button blue-gradient icon-pencil with-tooltip" title="Alterar Cliente">
                        Editar
                    </button>
                @endcan
            </span>
        </h4>
        <p class="boxed left-border">
            Descrição: <strong> {{$data->description}}</strong><br><br>
            Data: <strong> {{date('d/m/Y H:i:s', strtotime($data->created_at))}} </strong>
            @if($data->created_at != $data->updated_at)
                <br>Alterado: <strong> {{date('d/m/Y H:i:s', strtotime($data->updated_at))}} </strong>
            @endif
            <br>Por: <strong>{{$data->admin}}</strong>
        </p>
    </div>
@empty
    <p class="boxed left-border">Não há nehuma observação!</p>
@endforelse
