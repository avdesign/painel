<div id="load-contact-{{$data->id}}" class="large-box-shadow white-gradient with-border">
    <div class="button-height with-mid-padding silver-gradient no-margin-top">
        <h4 class="blue underline">{{$data->subject}} <span class="float-right">{{$data->name}}</span></h4>
        @if($data->send == 1)
            <button class="button float-right" title="Atendente">{{$data->admin}}</button>
            <span class="button-group">
                <button class="button icon-mail" title="Retorno">Retorno: {{$data->date_return}}</button>
            </span>
        @else
            <span class="button-group children-tooltip">
                <button onclick="openResponse('1','{{$data->id}}')" class="button blue-gradient icon-plus-round" title="Responder">Responder</button>
                <button onclick="openResponse('0','{{$data->id}}')" class="button red-gradient" title="Fechar"><span class="icon-minus-round"></span></button>
            </span>
        @endif
    </div>
    <div id="response-email-{{$data->id}}" class="with-padding" style="display: none">
        <form id="form-contact-{{$data->id}}" method="POST" action="{{route('contacts.response', $data->id)}}" onsubmit="return false">
            {{csrf_field()}}
            <fieldset class="fieldset">
                <legend class="legend">Mensagem</legend>
                <p class="button-height">
                    <textarea name="return" rows="10" class="input full-width"></textarea>
                </p>
                <div class="button-height align-right">
                    @can('cantact-response')
                        <button id="btn-response" onclick="responseMail($(this.form).attr('id'),'Aguarde', 'Enviar');" class="button icon-paper-plane blue-gradient"> Enviar </button>
                    @endcan
                </div>

            </fieldset>
        </form>
    </div>
    @if($data->send == 1)
        <div class="with-padding">
            <h4 class="green underline">Retorno</h4>
            <p>Olá {{$data->name}}</p>
            {!! nl2br($data->return) !!}
            <p/>
            <p>Atenciosamente,</p>
            <p/>
            <p>{{$data->admin}}</p>
            <p/>
            <p>{{env('DT_NAME')}}<br>{{env('DT_PHONE')}}</p>
        </div>
    @endif
    <div class="with-padding">
        <h4 class="green underline">Mensagem</h4>
        {!! nl2br($data->message) !!}
    </div>
</div>