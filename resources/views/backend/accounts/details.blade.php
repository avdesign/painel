<div class="large-box-shadow white-gradient with-border">
    <div class="with-padding">
        <h4 class="blue underline">{{$data->profile->name}}
            @if($data->deleted_at == null)
                <span class="button-group float-right compact">
                    @can('account-update')
                        <button id="btn-editar" onclick="abreModal('Alterar Cliente: {{$data->first_name}}', 'clientes/{{$data->id}}/edit', 'dados-clientes', 2, 'true', 400, 500);" class="button blue-gradient icon-pencil with-tooltip" title="Alterar Cliente">
                            Editar
                        </button>
                    @endcan
                </span>
            @endif
        </h4>
        @if($data->profile_id == 3)
            <p>Razão Social: <strong> {{$data->last_name}} </strong></p>
            <p>Nome Fantasia: <strong> {{$data->first_name}} </strong></p>
        @else
            <p>Nome: <strong> {{$data->first_name}} {{$data->last_name}} </strong></p>
        @endif
        <p>Email: <strong> {{$data->email}} </strong></p>
        <p>Telefone: <strong> {{$data->phone}} </strong></p>
        <p>Celular: <strong> {{$data->cell}} </strong></p>
        @if($data->active == constLang('active_true'))
            <p>Status: <strong> <small class="tag">{{constLang('active_true')}}</small> </strong></p>
        @else
            <p>Status: <strong> <small class="tag red-bg">{{constLang('active_false')}}</small> </strong></p>
        @endif
        <p>Vendedor: <strong> {{$data->admin}} </strong></p>
        @if($data->client == 1)
            <p>Cliente: <strong> <small class="tag">Sim</small> </strong></p>
        @else
            <p>Cliente: <strong> <small class="tag red-bg">Não</small> </strong></p>
        @endif
        <p>Data Nascimento: <strong> {{$data->date}} </strong></p>
        <p>Total de Visitas: <strong> {{$data->visits}} </strong></p>
        <p>Data Cadastro: <strong> {{date('d/m/Y H:i:s', strtotime($data->created_at))}} </strong></p>
        <p>Alterou Cadastro: <strong> {{date('d/m/Y H:i:s', strtotime($data->updated_at))}} </strong></p>
        <p>Último Login:<strong> @if($data->last_login != '') {{date('d/m/Y H:i:s', strtotime($data->last_login))}} @endif </strong></p>
        <p>Último Logout:<strong> @if($data->logout != '') {{date('d/m/Y H:i:s', strtotime($data->logout))}} @endif </strong></p>
        <p>IP: <strong> {{$data->ip}} </strong></p>
        @if($data->deleted_at != null)
            <p>Data Excluido: <strong> {{$data->deleted_at}} </strong></p>
        @endif
    </div>
</div>
