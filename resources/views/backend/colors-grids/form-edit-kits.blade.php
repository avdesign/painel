<div id="grids-{{$data->id}}">
    @foreach($grids as $val)
        @php
            $idkit  = $val->id;
            $keys[] = explode(",", $val->grid);
        @endphp
    @endforeach
    @foreach($keys as $values)
        @foreach($values as $key => $grid)
            @php
                $exp = explode("/", $grid);
                $qty = $exp[0];
                $grd = $exp[1];
            @endphp
            <button for="grid-{{$key}}" class="button blue-gradient margin-bottom">{{$grid}}</button>
        @endforeach
    @endforeach
</div>

<input type="hidden" name="grids[id]" value="{{$idkit}}">