<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{

    protected $fillable = [
        'module_id',
        'admin_id',
        'profile_id',
        'permission_id',
        'name',
        'label'
    ];
}
