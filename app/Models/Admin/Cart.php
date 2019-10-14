<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'image_color_id',
        'grid_product_id',
        'grid',
        'key',
        'quantity',
        'image',
        'color',
        'code',
        'profile',
        'offer',
        'percent',
        'price_card',
        'price_cash',
        'slug',
        'kit',
        'kit_name',
        'name',
        'category',
        'section',
        'brand',
        'unit',
        'measure',
        'weight',
        'width',
        'height',
        'length',
        'cost',
        'ip',
        'session'
    ];

}
