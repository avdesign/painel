<h2 class="relative thin">
    Atendentes
    <span class="info-spot">
    <span class="icon-info-round"></span>
    <span class="info-bubble">
      Selecione um atendente para este cliente.
    </span>
  </span>
  <span class="button-group absolute-right">
      <strong>Total de Clientes</strong>
  </span>
</h2>

<ul class="list">
    @foreach($admins as $admin)
        <li>
            <span class="list-link {{$admin['icon']}} icon-user">
                <strong>{{$admin['name']}}</strong> {{$admin['profile']}} <strong>{{$admin['status']}}</strong>
            </span>
            <div class="absolute-right compact margin-right">
                <strong>{{$admin['count']}} </strong>
            </div>
        </li>
    @endforeach
</ul>

<h4 class="anthracite underline">Selecione um atendente</h4>
<form id="edit-wishlist-admin" action="{{route('wishlist.admin.store', $user_id)}}" method="POST" onsubmit="return false">
    <input name="_method" type="hidden" value="PUT">
    {{csrf_field()}}
    <ul class="list">
        <li>
            @foreach($admins as $admin)
                @if($admin['status'] == 'Ativo')
                    <input type="radio" class="checkbox" name="admin" id="radio-{{$loop->index}}" value="{{$admin['name']}}"{{$admin['checked']}}>
                    <label for="radio-{{$loop->index}}" class="label"><strong>{{$admin['name']}}</strong></label>&nbsp;&nbsp;&nbsp;&nbsp;
                @endif
            @endforeach
        </li>
    </ul>

    <p class="button-height align-center">
        <span class="button-group">
            <button onclick="fechaModal()" class="button"> Cancelar </button>
            <button id="btn-modal" onclick="formEditWishlist('edit-wishlist-admin')" class="button icon-publish blue-gradient"> Salvar </button>
        </span>
    </p>

</form>


