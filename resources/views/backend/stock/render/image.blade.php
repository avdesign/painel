@if ($image->image != '')
    <a href="javascript:void(0)">
        <img id="img-'.$val->id.'" src="{{url($photoUrl.$path.$image->image)}}" width="80" />
    </a>
    @if($image->cover == 1)
        <p><small class="tag">{{constLang('cover')}}</small></p>
    @endif
@else
    <img src="{{url('backend/img/default/no_image.png')}}" />
@endif
