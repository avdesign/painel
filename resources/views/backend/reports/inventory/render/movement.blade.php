<span class="black">{{constLang('movement')}}:</span> {{$collect->type_movement}}<br>
<span class="black">{{constLang('quantity')}}:</span> {{$collect->amount}}<br>
<span class="black">{{constLang('previous')}}:</span> {{$previous_stock}}<br>
<span class="black">{{constLang('current')}}:</span> {{$collect->stock}}<br>
@if($collect->difference)
<span class="red">{{constLang('difference')}}:</span> {{$collect->difference}}
@endif
