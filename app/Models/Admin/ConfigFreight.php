<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigFreight extends Model
{
    protected $fillable = [
        'default',
        'distribute_box',
        'weight',
        'width',
        'height',
        'length',
        'declare'
    ];
}
