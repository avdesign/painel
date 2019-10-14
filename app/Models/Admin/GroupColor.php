<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GroupColor extends Model
{
    protected $fillable = [
        'config_color_group_id',
        'product_id',
        'image_color_id',
        'pinker',
        'label'
    ];

    public $timestamps = false;
}
