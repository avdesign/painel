<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SocialShare extends Model
{
    protected $fillable = [
        'name',
        'share',
        'link',
        'active'
    ];
}
