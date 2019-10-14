<div align="center">
    <p class="margin-top">Grupo de Cores</p>
    <span id="miniature-{{$idpro}}" class="display-none"></span>
    <select id="colors-piker-{{$idpro}}" name="piker[]" multiple="multiple">
        @foreach($groupColors as $color)
            <option value="{{$color->code}}" {{in_array($color->id, $group) ? 'selected' : ''}}>{{$color->id.':'.$color->name}}</option>
        @endforeach 
    </select>
    <span id="group-colors-{{$idpro}}" class="display-none"></span>
</div>
<script>
    // Grupo Cores
    var checks = '<span  class="groups">';
    $( "#colors-piker-{{$idpro}} option:selected" ).each(function() {
        var color = $( this ).val(),
        title = $( this ).text(),
        idc = color.replace("#","");
        checks += '<input id="'+idc+'" type="checkbox" name="groups['+color+']"  value="'+title+'" checked>';
    });
    checks += '</span>';
    $( "#group-colors-{{$idpro}}" ).html( checks );
    $('#miniature-{{$idpro}}').on('click', function() {
        $('select[name="piker[]"]').simplecolorpicker({
            multiple: true,
            element: 'group-colors-{{$idpro}}',
            theme: 'fontawesome'
        });
    });
    $('#miniature-{{$idpro}}').trigger('click');
</script>
