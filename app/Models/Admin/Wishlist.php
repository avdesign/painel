<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'key',
        'user_id',
        'product_id',
        'image_color_id',
        'grid_product_id',
        'grid',
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
        'ip'
    ];


    /**
     * @param string $id
     * @return array
     */
    public function rules($id='')
    {
        return [
            "quantity" => "required"
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }





}
