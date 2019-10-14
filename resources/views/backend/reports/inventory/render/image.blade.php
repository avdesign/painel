@if ($collect->image != '')
    <a href="javascript:void(0)"><img id="img-{{$collect->id}}" src="{{$photoUrl}}" width="80" /></a>
@else
    <img src="'.url('backend/img/default/no_image.png').'" />
@endif