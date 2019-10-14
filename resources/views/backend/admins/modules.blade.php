<div class="block-title">
    <h3><span class="icon-lock"> </span><strong> {{$title}} </strong></h3>
</div>
<div class="white-gradient">
    <dl class="accordion same-height">
        @foreach($modules as $module)
            <dt class="closed" onclick="openPermissions('{{$module->id}}','{{route('admin.permissions.data', ['id' => $admin->id, 'idmod' => $module->id])}}')"> {{$module->order}} - {{$module->name}}</dt>
            <dd>
                <div id="simulate" class="with-padding" @if($loop->index == 0 && $module->name == 'Usuários do Sistema') style="height:550px;" @else style="height:200px;" @endif>
                    <h5 class="blue underline"> {{$module->label}}  <span id="loader-{{$module->id}}" class="loader" style="display: none"></span></h5>
                    <div id="permisions-{{$module->id}}"></div>
                </div>
            </dd>
        @endforeach
    </dl>
</div>

<script>
    $( "dt:first" ).trigger( "click" );
    setTimeout(function(){
        $( "#simulate" ).css('height','100%');
    }, 5000);
</script>