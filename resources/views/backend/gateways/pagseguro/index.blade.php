<p class="message icon-info-round white-gradient">Lembrando que o limite para busca através da API é de 120 dias, para obter a lista de transações com uma data anterior a essa será necessário verificar no extrato de transações de sua conta PagSeguro.</p>

<div class="block">
    <div class="with-padding">
        <div class="columns">
            <div class="six-columns">
                <h4 class="blue underline"> {{$content->company}}</h4>

                <p>{{$content->status}}: <strong id="status-{{$order->id}}">{{config("pagseguro.status.$transaction->status.label")}}</strong></p>
                <p>{{$content->total}}: <strong>{{$transaction->grossAmount}}</strong></p>
                <p>{{$content->feeAmount}}: <strong>{{$transaction->feeAmount}}</strong></p>
                <p>{{$content->netAmount}}: <strong>{{$transaction->netAmount}}</strong></p>

            </div>
            <div class="six-columns">
                <h4 class="blue underline">{{$content->order}}: {{$order->reference}}</h4>
                <div class="margin-top">
                    @if($order->config_status_payment_id == 1 || $order->config_status_payment_id == 2)
                        <form id="cancel-transaction-{{$order->id}}" method="POST" action="{{route('pagseguro-cancel')}}" onsubmit="return false">
                            <div style="display: none">
                                @method("PUT")
                                @csrf
                                <input type="hidden" name="id" value="{{$order->id}}">
                            </div>
                            <div class="align-right">
                                <button id="submit-cancel-transaction-{{$order->id}}" type="submit" class="button glossy" onclick="confirmCancel($(this.form).attr('id'));">
                                    Cancelar Transação
                                    <span  id="btn-cancel-transaction-{{$order->id}}" class="button-icon red-gradient right-side"><span class="icon-cross-round"></span></span>
                                </button>
                            </div>
                        </form>
                    @endif

                    @if($order->config_status_payment_id == 3 || $order->config_status_payment_id == 4 || $order->config_status_payment_id == 5)
                        <form id="reverse-transaction-{{$order->id}}" method="POST" action="{{route('pagseguro-reverse')}}" onsubmit="return false">
                            <div style="display: none">
                                @method("PUT")
                                @csrf
                                <input type="hidden" name="id" value="{{$order->id}}">
                            </div>
                            <ul class="bullet-list">
                                <li>A Transação deverá estar com os status Paga, Disponível ou Em disputa.</li>
                                <li>O valor do estorno é corresponde ao valor a ser devolvido. Se não for informado, o PagSeguro assume que o valor a ser estornado é o valor total da transação.</li>
                            </ul>

                            <p class="inline-small-label button-height">
                                <label for="refundValue" class="label"><strong>Valor:</strong></label>
							    <input type="text" name="refundValue" id="refundValue" class="input small-margin-right" value="">
                            </p>

                            <div class="align-center">
                                <button id="submit-reverse-transaction-{{$order->id}}" type="submit" class="button glossy" onclick="confirmReverse($(this.form).attr('id'));">
                                    Estornar Transação
                                    <span  id="btn-reverse-transaction-{{$order->id}}" class="button-icon red-gradient right-side"><span class="icon-cross-round"></span></span>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ mix('backend/scripts/gateways/pagseguro.min.js') }}"></script>

