<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigPermission extends Model
{
    protected $fillable = [
        'module_id', 'name', 'label'
    ];

    /**
     * Validação
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "module_id" => "required|integer",
            "name"      => "required|unique:config_permissions,name,{$id},id",
            "label"     => "required"
        ];
    }

    /**
     * Profiles vinculados as permissões
     * @return array
     **/
    public function profiles()
    {
        return $this->belongsToMany(ConfigProfile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module()
    {
        return $this->belongsTo(ConfigModule::class, 'module_id');
    }
}
