<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductCost extends Model
{
    protected $fillable = [
        'product_id',
        'value'
    ];
}
