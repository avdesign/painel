<div id="load-contact-{{$data->id}}" class="large-box-shadow white-gradient with-border">
    <div class="button-height with-mid-padding silver-gradient no-margin-top">
        <h4 class="blue underline">{{$data->subject}} <span class="float-right">{{$data->name}}</span></h4>

    </div>

    <div class="with-padding">
        <h4 class="green underline">Mensagem</h4>
        {!! nl2br($data->message) !!}
    </div>
</div>