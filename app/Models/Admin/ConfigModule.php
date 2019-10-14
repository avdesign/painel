<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigModule extends Model
{
    protected $fillable = [
        'type', 'name', 'label', 'order'
    ];

    /**
     * Validação
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "type"     => "required",
            "name"      => "required|unique:config_modules,name,{$id},id",
            "label"     => "required",
            "order"     => "required"
        ];
    }


    /**
     * Permissões vinculados aos modulos
     * @return array
     **/
    public function permissions()
    {
        return $this->hasMany(ConfigPermission::class, 'module_id');
    }


}


