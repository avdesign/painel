<span class="black">{{constLang('movement')}}:</span> {{$collect->movement_type}}<br>
<span class="black">{{constLang('quantity')}}:</span> {{$collect->movement_qty}}<br>
<span class="black">{{constLang('previous')}}:</span> {{$collect->previous}}<br>
<span class="black">{{constLang('current')}}:</span> {{$collect->stock}}<br>
@if($collect->diff_qty)
<span class="red">{{constLang('difference')}}:</span> {{$collect->diff_qty}}
@endif
