<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{

    protected $fillable = [
        'order_id',
        'user_id',
        'config_shipping_id',
        'indicate',
        'code',
        'url',
        'phone',
        'name',
        'note',
        'status',
        'date_send'
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
            "config_shipping_id" => "required",
            "status"             => "required"
        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function configShipping()
    {
        return $this->belongsTo(ConfigShipping::class);
    }



}
