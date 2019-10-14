<div class="white-gradient">
    <div id="form-payments" class="with-padding">
        <dl class="accordion same-height">
            @forelse($data as $value)
                <dt id="payment-{{$value->id}}"><strong>{{$value->order}}</strong> - {{$value->label}}
                <div class="button-group absolute-right compact margin">
                    <button id="btn-reactivate-{{$value->id}}" onclick="formPaymentsReactivate('{{$value->id}}', '{{route('forms-payments.reactivate', $value->id)}}')" class="button icon-tick with-tooltip blue-gradient" title="Ativar">Reativar</button>
                </div>
                </dt>
                <dd>
                    <div class="with-padding">
                        <strong>Descrição: </strong>{{$value->description}}
                    </div>
                </dd>

            @empty
                <p class="boxed left-border">Não existe status excluidos</p>
            @endforelse
        </dl>
    </div>
</div>