<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'config_profile_client_id',
        'profile',
        'price_card',
        'price_cash',
        'offer_card',
        'offer_cash',
        'price_cash_percent',
        'price_card_percent',
        'offer_percent',
        'sum_cash',
        'sum_card'
    ];
}
