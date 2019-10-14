<div id="modal-template">
    <form id="form-template" method="POST" action="{{route('template-site.update', $data->id)}}" onsubmit="return false">
        @method('PUT')
        @csrf
        <fieldset class="fieldset">
            <p class="block-label button-height">
                <label for="page" class="label">Página do Site <span class="red">*</span></label>
                <select id="config page id" name="config page id" class="select">
                    <option value="">Selecione um</option>

                @foreach($pages as $page)
                        <option value="{{$page->id}}" @if($page->id == $data->config_page_id) selected @endif>{{$page->name}}</option>
                    @endforeach
                </select>
            </p>
            <p class="block-label button-height">
                <label for="name" class="label">{{$config['fields']['name']}} <span class="red">*</span></label>
                <input type="text" name="name" class="input" value="{{$data->name}}">
            </p>
            <p class="block-label button-height">
                <label for="module" class="label">{{$config['fields']['module']}}<span class="red">*</span></label>
                <input type="text" name="module" class="input" value="{{$data->module}}">
            </p>
            <p class="block-label button-height">
                <label for="tmp" class="label">{{$config['fields']['tmp']}} / {{$config['fields']['status']}} <span class="red">*</span></label>
                <span class="number input margin-right">
                    <button type="button" class="button number-down">-</button>
                    <input type="text" name="tmp" value="{{$data->tmp}}" class="input-unstyled order" size="2">
                    <button type="button" class="button number-up">+</button>
                </span>
                <span class="button-group">
					<label for="active-1" class="button blue-active">
						<input type="radio" name="active" id="active-1" value="{{constLang('active_true')}}" @if($data->active == constLang('active_true')) checked @endif>
                        {{constLang('active_true')}}
					</label>
					<label for="active-0" class="button red-active">
						<input type="radio" name="active" id="active-0" value="{{constLang('active_false')}}" @if($data->active == constLang('active_false')) checked @endif>
                        {{constLang('active_false')}}
					</label>
				</span>
            </p>
            <p class="button-height align-center">
                <span class="button-group">
                    @can('config-site-delete')
                        <button onclick="deleteModule('{{$data->id}}','{{route('template-site.destroy', $data->id)}}','{{csrf_token()}}')" class="button icon-trash red-bg"></button>
                    @endcan
                    <button onclick="fechaModal()" class="button"> {{$config['fields']['cancel']}} </button>
                    @can('config-site-update')
                        <button id="btn-modal" onclick="formTemplate('update', 'template', '{{route('page-site-load')}}')" class="button blue-gradient">
                        <span class="icon-publish"></span> {{$config['fields']['update']}}
                    </button>
                    @endcan
                </span>
            </p>
        </fieldset>
    </form>
</div>