<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigShipping extends Model
{
    protected $fillable = [
        'name',
        'description',
        'order',
        'active',
        'tax',
        'tax_unique',
        'tax_condition'

    ];

    /**
     * Validação
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "name"          => "required|unique:config_shippings,name,{$id},id",
            "description"   => "required",
            "order"         => "required|unique:config_shippings,order,{$id},id",
            'tax'           => 'required',
            'tax_unique'    => 'required',
            'tax_condition' => 'required'
        ];
    }
}
