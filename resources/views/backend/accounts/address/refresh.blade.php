@forelse($addresses as $data)
    <h4 class="blue underline">
        @if($data->delivery == 1) Endereço de Entrega @else Outro Endereço @endif
        <span class="button-group float-right compact">
           @can('account-update')
                <button id="btn-editar" onclick="abreModal('Alterar Endereço', '{{route('address.edit', ['id' => $data->id, 'user_id' => $data->user_id])}}', 'dados-clientes', 2, 'true', 400, 500);" class="button blue-gradient icon-pencil with-tooltip" title="Alterar Cliente">
                  Editar
                </button>
            @endcan
        </span>
    </h4>
    <p>Endereço: <strong> {{$data->address}} </strong></p>
    <p>Número: <strong> {{$data->number}} </strong></p>
    <p>Complemento: <strong> {{$data->complement}} </strong></p>
    <p>Bairro: <strong> {{$data->district}} </strong></p>
    <p>Cidade: <strong> {{$data->city}} </strong></p>
    <p>Estado: <strong> {{$data->state}} </strong></p>
    <p>CEP: <strong> {{$data->zip_code}} </strong></p>
    <p>Data Registro: <strong> {{date('d/m/Y H:i:s', strtotime($data->created_at))}} </strong></p>
    <p>Data Alteração: <strong> {{date('d/m/Y H:i:s', strtotime($data->updated_at))}} </strong></p>
@empty
    <div class="large-box-shadow white-gradient with-border">
        <div class="with-padding">
            <h4 class="blue underline">
                Não existe endereço cadastrado!
                <span class="button-group float-right compact">
                @can('account-create')
                        <button id="btn-create" onclick="abreModal('Adicionar Endereço', '{{route('address.create', $user->id)}}', 'add-address', 2, 'true', 400, 500);" class="button blue-gradient icon-pencil with-tooltip" title="Adicionar Endereço">
                    Adicionar
                    </button>
                    @endcan
            </span>
            </h4>
        </div>
    </div>
@endforelse