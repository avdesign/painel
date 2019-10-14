<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigBox extends Model
{
    protected $fillable = [
        'width',
        'height',
        'length'
    ];
}
