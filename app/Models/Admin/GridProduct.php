<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GridProduct extends Model
{
    protected $fillable = [
        'product_id',
        'image_color_id',
        'color',
        'kit',
        'units',
        'qty_min',
        'qty_max',
        'grid',
        'input',
        'output',
        'stock'
    ];

    public $timestamps = false;


    /**
     * Product
     * @return array
     **/
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Image
     * @return array
     **/
    public function image()
    {
        return $this->belongsTo(ImageColor::class, 'image_color_id');
    }

}
