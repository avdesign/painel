<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'config_form_payment_id',
        'config_status_payment_id',
        'config_shipping_id',
        'company',
        'status_label',
        'qty',
        'percent',
        'price_card',
        'price_cash',
        'subtotal',
        'total',
        'coupon',
        'discount',
        'freight',
        'tax',
        'ip',
        'code',
        'reference',
        'token'
    ];


    /**
     *  Data de exclusão do registro
     */
    protected $dates = ['deleted_at'];



    /**
     * @param string $id
     * @return array
     */
    public function rules($id='')
    {
        return [
            "user_id"                   => "required",
            "config_status_payment_id"  => "required",
            "config_form_payment_id"    => "required"
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function configFormPayment()
    {
        return $this->belongsTo(ConfigFormPayment::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function configStatusPayment()
    {
        return $this->belongsTo(ConfigStatusPayment::class);
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(OrderNote::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shippings()
    {
        return $this->hasMany(OrderShipping::class);
    }

}