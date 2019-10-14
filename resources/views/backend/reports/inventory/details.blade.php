<div class="block">
    <div class="with-padding">
        <h4 class="blue underline">{{constLang('messages.inventory.title_note')}}</h4>
        @if($data->note)
            <p><span class="black">{{constLang('note')}}:</span> {{$data->note}}</p>
        @endif
    </div>
</div>