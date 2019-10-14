<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigProfile extends Model
{
    protected $fillable = ['name', 'label'];

    /**
     * Validação
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "name"      => "required|unique:config_profiles,name,{$id},id",
            "label"     => "required"
        ];
    }

    /**
     * Usuários vinculados ao perfil
     * @return array
     **/
    public function users()
    {
        return $this->belongsToMany(Admin::class);
    }


    /**
     * permissões vinculadas ao perfil
     * @return array
     **/
    public function permissions()
    {
        return $this->belongsToMany(ConfigPermission::class);
    }
}
