<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigColorGroup extends Model
{
    protected $fillable = [
        'name',
        'code',
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
            "code"  => "required|unique:config_color_groups,code,{$id},id",
            "name"  => "required|unique:config_color_groups,name,{$id},id",
            "order" => "required"
        ];
    }
}
