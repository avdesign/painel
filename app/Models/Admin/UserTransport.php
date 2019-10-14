<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UserTransport extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone'
    ];
}
