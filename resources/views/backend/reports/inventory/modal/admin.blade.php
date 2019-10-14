@php
    ($data->active == constLang('active_true') ? $color='green' : $color='red');
@endphp

<h3 class="thin underline {{$color}}"><span class="black">{{constLang('name')}}: </span>{{$data->name}}</h3>
<h3 class="thin underline {{$color}}"><span class="black">{{constLang('status')}}: </span>{{$data->active}}</h3>
<h3 class="thin underline {{$color}}"><span class="black">{{constLang('profile')}}: </span>{{$data->profile}}</h3>
<p><span class="black">{{constLang('mail')}}:</span> {{$data->email}}</p>
<p><span class="black">{{constLang('phone')}}:</span> {{$data->phone}}</p>
<div class="align-center">
    <button onclick="fechaModal()" class="button icon-cross-round black-gradient"> {{constLang('close')}} </button>
</div>
