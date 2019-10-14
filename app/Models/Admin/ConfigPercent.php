<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigPercent extends Model
{
    protected $fillable = [
        'percent',
        'order',
        'active'
    ];

    /**
     * Validação
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "percent"  => "required|unique:config_percents,percent,{$id},id",
            "order"    => "required"
        ];
    }
}
