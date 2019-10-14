<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigStatusPayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order',
        'status',
        'gateway',
        'type',
        'label',
        'description',
        'active'
    ];

    /**
     *  Data de exclusão do registro
     */
    protected $dates = ['deleted_at'];


    /**
     * Validação
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            'gateway'     => "required",
            "label"       => "required|unique:config_status_payments,label,{$id},id",
            "description" => "required",
            "order"       => "required",
            "type"        => "required",
            "status"      => "required",
            "active"      => "required"
        ];
    }
}
