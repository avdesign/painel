<span class="black">{{date('d/m/Y H:i:s', strtotime($collect->updated_at))}}</span> <br>
@if($collect->admin_id !== null)
    <a href="javascript:abreModal(' ', '{{route('inventory.admin', numLetter($collect->admin_id, 'letter'))}}', 'inventory', 2, 'true', 300, 280);" class="button compact icon-user"></a><br>
@endif
@if($collect->user_id !== null)
    <a href="javascript:abreModal(' ', '{{route('inventory.user', $collect->user_id)}}', 'inventory', 2, 'true', 300, 350);" class="button compact icon-user"></a><br>
@endif
@if($collect->motive)
    <p style="margin-top: 8px; color: red">{{constLang('messages.inventory.motive.2')}}</p>
@endif