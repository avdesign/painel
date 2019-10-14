<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigSystem extends Model
{

    protected $fillable = [
        'admin_id',
        'table_color',
        'table_color_sel',
        'table_limit',
        'table_open_details'
    ];
}
