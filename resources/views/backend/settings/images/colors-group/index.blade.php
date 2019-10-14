<div class="block">
    <div class="block-title">
        <h3>{{$title}}</h3>

        @can('config-color-group-create')
            <div class="button-group absolute-right">
                <a href="javascript:abreModal('Adicionar Cor', '{{route('grupo-colors.create')}}', 'color-grup', 2, 'true', 400, 250)" class="button blue-gradient icon-plus-round">Adicionar</a>
            </div>
        @endcan
    </div>
    <div class="with-padding">
        <ul id="colors" class="files-icons mini">
            @foreach($data as $hexa)
                <li>                
                    <button id="color_{{$hexa->id}}" class="color with-tooltip" title="{{$hexa->order}}: {{$hexa->name}}" data-tooltip-options='{"classes":["anthracite-gradient"],"position":"bottom"}'  style="background-color:{{$hexa->code}}; width:40px;height:40px" ></button>
                    <span class="controls">
                        <span class="button-group compact">
                            @can('config-color-group-update')
                                <a href="javascript:abreModal('Editar {{$hexa->name}}', '{{route('grupo-colors.edit', $hexa->id)}}', 'color-grup', 2, 'true', 400, 250)" class="button icon-pencil" title="Editar"></a>
                            @endcan
                            @can('config-color-group-delete')
                                <a href="javascript:deleteColorGrup('{{$hexa->id}}', '{{route('grupo-colors.destroy', $hexa->id)}}', '{{csrf_token()}}')" class="button icon-trash red-gradient confirm" title="Excluir"></a>
                            @endcan
                        </span>
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<script src="{{mix('backend/scripts/settings/colors-group.min.js')}}"></script>
