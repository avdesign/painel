<div class="block">
    <div class="with-padding">
        <div class="float-right"></div>
        <h4 class="blue underline">{{$title}}</h4>
        <ul class="bullet-list">
            <li id="dname">Nome: <strong> {{ $data->name }} </strong></li>
            <li id="demail">Email: <strong> {{ $data->email }} </strong></li>
            <li id="dtelefone">Telefone: <strong> {{ $data->phone }} </strong></li>
            <li id="dnivel">Perfil: <strong> {{ $data->profile }} </strong></li>
            @if($data->active == constLang('active_true'))
                <li id="dstatus">Status: <small class="tag blue-bg">{{constLang('active_true')}}</small> </li>
            @else
                <li id="dstatus">Status: <small class="tag red-bg">{{constLang('active_false')}}</small> </li>
            @endif
            <li id="dporcento">Comissao: <strong> {{ $data->commission }}  {{ $data->percent }} %</strong></li>
        </ul>
    </div>
</div>
<script>
    $(".block").click(function (){return false;});
</script>