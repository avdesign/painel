<div class="block large-margin-bottom">

    <div class="block-title">
        <h3><span class="icon-mail" title="icon-mail"></span> {{$title}}</h3>
        @can('config-subject-create')
            <div class="button-group absolute-right compact">
                <button onclick="abreModal('{{$title_create}}', '{{route('contact-subjects.create')}}', 'subjects', 2, true, 460, 450)" title="{{$title_create}}" class="button icon-plus-round with-tooltip anthracite-gradient">Adicionar</button>
            </div>
        @endcan
    </div>

    <ul id="list-subjects" class="events">
        @foreach($data as $value)
            <li>
                <div class="button-group absolute-right compact margin-right">
                    @can('config-subject-update')
                        <button onclick="abreModal('{{$title_edit}} {{$value->label}}', '{{route('contact-subjects.show', $value->id)}}', 'subjects', 2, true, 460, 450);" class="button icon-pencil">Editar</button>
                    @endcan
                </div>
                <span class="event-date orange">{{$value->order}}</span>
                <h4>{{$value->label}}</h4>
                <p>
                    @if($value->active == constLang('active_true'))
                        <small class="tag blue-bg">{{constLang('active_true')}}</small>
                    @else
                        <small class="tag red-bg">{{constLang('active_false')}}</small>
                    @endif
                    <small class="tag icon-mail @if($value->send_guest == 1)blue-bg @else red-bg @endif">Visitante</small>
                    <small class="tag icon-mail @if($value->send_user == 1)blue-bg @else red-bg @endif">Cliente</small>
                <p>{{strip_tags($value->message)}}</p>
            </li>
        @endforeach
    </ul>
</div>
<script src="{{mix('backend/scripts/settings/subjects.min.js')}}"></script>
