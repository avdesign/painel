<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigProduct extends Model
{
    protected $fillable = [
        'price_default',
        'config_prices',
        'view_prices',
        'price_profile',
        'cost',
        'stock',
        'qty_min',
        'qty_min_unit',
        'qty_min_kit',
        'qty_max',
        'qty_max_unit',
        'qty_max_kit',
        'freight',
        'kit',
        'colors',
        'group_colors',
        'positions',
        'grids',
        'reviews',
        'quickview',
        'wishlist',
        'compare',
        'countdown',
        'video',
        'mini_colors'
    ];
}
