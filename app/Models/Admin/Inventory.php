<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'product_id',
        'image_color_id',
        'grid_id',
        'admin_id',
        'user_id',
        'profile_name',
        'note',
        'brand',
        'section',
        'category',
        'product',
        'image',
        'code',
        'color',
        'grid',
        'previous',
        'motive',
        'movement_type',
        'movement_qty',
        'diff_value',
        'diff_qty',
        'kit',
        'kit_name',
        'units',
        'offer',
        'cost_unit',
        'cost_total',
        'price_profile',
        'price_unit',
        'price_total',
        'form_payment',
        'stock'
    ];






}
