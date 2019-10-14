<div class="block large-margin-bottom">

    <div class="block-title">
        <h3><i class="fa fa-truck"></i> {{$config['title_index']}}</h3>
        @can('contents-site-create')
            <div class="button-group absolute-right compact">
                <button onclick="abreModal('{{$config['title_create']}}', '{{route('delivery-return.create')}}', 'contents', 2, true, 600, 700)" title="{{$config['title_create']}}" class="button icon-plus-round with-tooltip anthracite-gradient">Adicionar</button>
            </div>
        @endcan
    </div>

    <ul id="list-contents" class="events">
        @foreach($data as $key => $value)
        <li id="content-{{$value->id}}">
            @if($key >= 1)
                <span id="number-{{$value->id}}" class="event-date orange">{{$value->order}}</span>
            @endif
            <h4 id="title-{{$value->id}}">{{$value->title}}</h4>
            <div class="button-group compact">
                @can('contents-site-update')
                    <button onclick="abreModal('{{$config['title_edit']}}', '{{route('delivery-return.show', $value->id)}}', 'contents', 2, true, 700, 600)" class="button icon-pencil with-tooltip" title="Editar">Editar</button>
                    <button id="order-{{$value->id}}" class="button icon-gear with-tooltip tracked" title="Alterar Ordem">Ordem</button>
                    <button id="status-{{$value->id}}" onclick="statusContent('{{$value->id}}','{{route('delivery-return.status', $value->id)}}','{{csrf_token()}}')" title="Alterar Status" class="button icon-tick with-tooltip @if($value->active == constLang('active_false'))red @endif">{{$value->active}}</button>
                @endcan
                @can('contents-site-delete')
                    <button onclick="deleteContent('{{$value->id}}', '{{route('delivery-return.destroy', $value->id)}}', '{{csrf_token()}}')" class="button icon-trash with-tooltip red-bg" title="Excluir"></button>
                @endcan
            </div>
            <div class="large-margin-bottom">
                <script>$("#order-{{$value->id}}").menuTooltip("Carregando...",{classes:["with-mid-padding"],ajax:"{{route('delivery-return.order', $value->id)}}",onShow:function(e){e.parent().removeClass("show-on-parent-hover")},onRemove:function(e){e.parent().addClass("show-on-parent-hover")}});</script>
            </div>
            <div id="description-{{$value->id}}">
                <p>{!! nl2br($value->description) !!}</p>
            </div>
        </li>
        @endforeach
    </ul>
</div>
<script src="{{mix('backend/scripts/content-site.min.js')}}"></script>
