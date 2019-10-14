<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'brand_id',
        'section_id',
        'category_id',
        'name',
        'description',
        'brand',
        'section',
        'category',
        'slug',
        'tags',
        'video',
        'unit',
        'measure',
        'declare',
        'weight',
        'width',
        'height',
        'length',
        'cost',
        'kit_name',
        'kit',
        'stock',
        'qty_min',
        'qty_max',
        'freight',
        'new',
        'featured',
        'offer',
        'offer_date',
        'active',
        'trend',
        'black_friday',
        'visits'
    ];

    /**
     * Prices
     * @return array
     **/
    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }


    /**
     * Images
     * @return array
     **/
    public function images()
    {
        return $this->hasMany(ImageColor::class);
    }


    /**
     * Grids
     * @return array
     **/
    public function grids()
    {
        return $this->hasMany(GridProduct::class);
    }


    public function cost()
    {
        return $this->hasOne(ProductCost:: class);
    }
}
