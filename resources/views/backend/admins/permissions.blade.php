@foreach($checks as $key => $ck)
	@can('model-admins-permissions-update')

		@if(substr($ck['name'], 0, 9) == 'reservado' && Auth::user()->profile != 'Master')

		@else
			<p>
				<input id="check_{{$ck['id']}}" onchange="javascript:$.fn.changePermission('{{$ck['id']}}', '{{route('admin.permission.update', $id)}}')"  type="checkbox" value="{{$ck['value']}}" class="checkbox mid-margin-left"{{$ck['checked']}}>
				<label for="permision-{{$ck['id']}}" class="label">{{$ck['label']}}</label>
			</p>

		@endif

	@endcan

@endforeach




	
