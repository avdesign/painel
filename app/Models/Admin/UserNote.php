<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UserNote extends Model
{
    protected $fillable = [
        'user_id',
        'admin',
        'label',
        'description'
    ];
}
