<form id="form-recover-password" method="POST" action="{{ route('admin.password.email') }}" onsubmit="return false">
    {{ csrf_field() }}
    <fieldset class="fieldset">
        @if(isset($data))
            <p><strong>{{$data->name}}, receberá por email um link para a redefinição da senha.</strong></p>
        @endif
        <p class="button-height inline-small-label">
            <label for="email" class="label"> Email <span class="red">*</span></label>
            <input type="email" name="email" class="input full-width" value="{{$data->email or old('email')}}">
        </p>
            <p class="button-height align-center">
                <span class="button-group">
                <button onclick="fechaModal()" class="button"> Cancelar </button>
                @if(isset($data))
                        <button id="btn-modal" onclick="recoverPassword('recover-password', 'aguarde', 'Enviar')" class="button icon-publish blue-gradient"> Enviar </button>
                @endif
                </span>
            </p>

    </fieldset>

</form>