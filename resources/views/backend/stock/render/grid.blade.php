<p>{{$product->kit_name}} <strong>{{$product->unit}} {{$product->measure}}</strong></p>
@if($product->kit == 1)
    <p><strong>{{$val->grid}}</strong></p>
@else
    <p>{{constLang('grid')}}: <strong>{{$val->grid}}</strong></p>
@endif